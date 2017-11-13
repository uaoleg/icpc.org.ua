<?php

namespace frontend\controllers;

use \common\models\Document;
use \common\models\News;
use \common\models\Team;
use \common\models\Result;
use \common\models\UploadedFile;
use \common\models\User;
use \yii\helpers\FileHelper;
use \yii\helpers\Url;
use \PHPHtmlParser\Dom;

class UploadController extends BaseController
{

    /**
     * Returns the access rules for this controller
     *
     * @return array
     */
    public function accessRules()
    {
        // Return rules
        return array(
            array(
                'allow',
                'actions'   => array('results'),
                'roles'     => array(\common\components\Rbac::OP_RESULT_CREATE),
            ),
            array(
                'deny',
                'actions'   => array('results'),
            ),
            array(
                'allow',
            ),
        );
    }

    /**
     * Upload document
     */
    public function actionDocument()
    {
        // Process file
        $filePath = $this->processFile();
        if (!$filePath) {
            return;
        }

        // Get params
        $title = \yii::$app->request->post('title');
        $desc  = \yii::$app->request->post('desc');
        $type  = \yii::$app->request->post('type');
        if (empty($title)) {
            $title = \yii::$app->request->post('name');
        }

        // Define file type
        $fileExt = mb_strtolower(mb_substr($filePath, strrpos($filePath, '.') + 1));

        // Create document
        $document = new Document([
            'title'     => $title,
            'desc'      => $desc,
            'type'      => $type,
            'fileExt'   => $fileExt,
            'content'   => file_get_contents($filePath),
        ]);
        $document->save();

        // Render item HTML
        $html = '';

        // Render json
        return $this->renderJson(array(
            'html'      => $html,
            'errors'    => $document->getErrors(),
        ));
    }

    /**
     * Upload results
     */
    public function actionResults()
    {
        // Process file
        $filePath = $this->processFile(true);
        if (!$filePath) {
            return;
        }

        // Get params
        $geo    = \yii::$app->request->post('geo');
        $year   = (int)date('Y');
        $resultsViewParams = array('year' => $year);

        // Create parser object
        $parser = new Dom;
        $html = $parser->load(file_get_contents($filePath));

        // Define phase and check access
        $school = \yii::$app->user->identity->school;
        switch ($geo) {
            case ($school->state):
                if (!\yii::$app->user->can(User::ROLE_COORDINATOR_STATE)) {
                    $this->httpException(403);
                }
                $phase = Result::PHASE_1;
                $resultsViewParams['state'] = $geo;
                break;
            case ($school->region):
                if (!\yii::$app->user->can(User::ROLE_COORDINATOR_REGION)) {
                    $this->httpException(403);
                }
                $resultsViewParams['region'] = $geo;
                $phase = Result::PHASE_2;
                break;
            case ($school->country):
                if (!\yii::$app->user->can(User::ROLE_COORDINATOR_UKRAINE)) {
                    $this->httpException(403);
                }
                $resultsViewParams['country'] = $geo;
                $phase = Result::PHASE_3;
                break;
            default:
                $this->httpException(404);
                break;
        }
        $resultsViewParams['phase'] = $phase;

        // Delete old version of results
        Result::deleteAll([
            'year'  => $year,
            'geo'   => $geo,
        ]);

        // Parse each row
        $letters = Result::TASKS_LETTERS;
        foreach ($html->find('tr') as $row => $tr) {

            // Skip first line
            if ($row === 0) {
                continue;
            }

            // Get team
            $teamName = $tr->find('.st_team', 0)->text();
            $team = Team::find()
                ->andWhere(['LIKE', 'name', $teamName])
                ->andWhere(['year' => $year])
                ->one()
            ;

            // Check team geo to match
            if ($team !== null) {
                if (($team->school->state !== $geo)
                        && ($team->school->region !== $geo)
                        && ($team->school->country !== $geo)) {
                    continue;
                }
            }

            // Parse tasks tries and time
            $tasksTries = $tasksTime = array();
            foreach ($tr->find('.st_prob') as $i => $prob) {
                $tmp = $output = preg_replace('!\s+!', ' ', trim($prob->text()));
                if ($tmp[0] === '-') {
                    $tasksTries[$letters[$i]] = (int)$tmp; // '-1' => -1, '-2' => -2, ...
                    $tasksTime[$letters[$i]]  = null;
                } elseif ($tmp[0] === '+') {
                    $tasksTries[$letters[$i]] = (int)$tmp + 1; // '+' => 1, '+1' => 2, ...
                    $time = preg_replace('/[()]/', '', $prob->find('.st_time', 0)->text());
                    list($timeHours, $timeMins) = explode(':', $time);
                    $tasksTime[$letters[$i]]  = $timeHours * SECONDS_IN_HOUR + $timeMins * SECONDS_IN_MINUTE;
                } else {
                    $tasksTries[$letters[$i]] = null;
                    $tasksTime[$letters[$i]]  = null;
                }
            }

            $place = $tr->find('.st_place', 0)->text();
            if ($place != '&nbsp;') {

                // Create result
                $result = new Result([
                    'teamId'    => (isset($team)) ? $team->id : null,
                    'teamName'  => (isset($team)) ? null : $teamName,
                    'year'      => (int)$year,
                    'phase'     => (int)$phase,
                    'geo'       => $geo,
                    'place'     => (int)$place,
                    'placeText' => $place,
                    'total'     => (int)$tr->find('.st_total', 0)->text(),
                    'penalty'   => (int)$tr->find('.st_pen', 0)->text(),
                ]);
                if (!$result->save()) {
                    return $this->renderJson(array(
                        'errors' => true,
                        'message' => \yii::t('app', 'Not all results were saved!')
                    ));
                    \yii::$app->end();
                } else {
                    foreach ($tasksTries as $letter => $tasksTry) {
                        $task = new Result\Task([
                            'resultId'      => $result->id,
                            'letter'        => $letter,
                            'triesCount'    => $tasksTry,
                            'secondsSpent'  => $tasksTime[$letter],
                        ]);
                        $task->save();
                    }
                }
            }
        }

        return $this->renderJson(array(
            'errors' => false,
            'url' => Url::toRoute(['/results/view'] + $resultsViewParams)
        ));
    }

    /**
     * Upload images
     */
    public function actionImages()
    {
        // Get uploaded images
        $newsId = \yii::$app->request->get('newsId');
        $imagesCount = (int)News\Image::find()
            ->andWhere(['newsId' => $newsId])
            ->count()
        ;

        if ($imagesCount < News::MAX_IMAGES_COUNT) {

            // Process file
            $filePath = $this->processFile();
            if (!$filePath) {
                return;
            }

            // Scale image
            \yii::$app->image->scale(
                $filePath,
                $filePath,
                [
                    'max_width' => 2000,
                    'max_height' => 2000,
                    'min_width' => 100,
                    'min_height' => 100,
                ]
            );

            // Create a new scaled and converted file
            $image = new News\Image([
                'newsId'    => (!empty($newsId)) ? $newsId : null,
                'userId'    => \yii::$app->user->id,
                'content'   => file_get_contents($filePath),
            ]);
            $image->save();

            // Return response
            return $this->renderJson([
                'errors' => false,
                'id' => $image->id,
            ]);
        } else {
            return $this->renderJson([
                'errors' => true,
                'message' => \yii::t('app', 'There are more than {0} images for this news. You cannot add any more.', News::MAX_IMAGES_COUNT),
            ]);
        }
    }

    /**
     * Upload user's profile photo
     */
    public function actionPhoto()
    {
        // Get current user
        $user = \yii::$app->user->identity;

        // Process file
        $filePath = $this->processFile();
        if (!$filePath) {
            return;
        }

        // Scale photo
        \yii::$app->image->scale(
            $filePath,
            $filePath,
            array(
                'max_width' => 2000,
                'max_height' => 2000,
                'min_width' => 100,
                'min_height' => 100,
            )
        );

        // Delete old photo if it exists
        if ($user->photo !== null) {
            $user->photo->delete();
        }

        // Create a new photo
        $photo = new User\Photo([
            'userId'   => \yii::$app->user->id,
            'content'  => file_get_contents($filePath),
        ]);
        $photo->save();

        // Delete temporary file
        unlink($filePath);

        // Render json
        return $this->renderJson(array(
            'errors' => false,
            'photoId' => $photo->id,
        ));
    }

    /**
     * Get upload dir
     *
     * @return string
     */
    protected function getUploadDir()
    {
        return \yii::getAlias('@runtime/uploads/' . \yii::$app->user->id);
    }

    /**
     * Process file upload
     * @link http://www.plupload.com/docs/Chunking
     * @return string path to the uploaded file
     */
    protected function processFile()
    {
        $chunk  = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;

        $fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : $_FILES["file"]["name"];
        $filePath = "{$this->getUploadDir()}/{$fileName}";
        FileHelper::createDirectory($this->getUploadDir());

        // Open temp file
        $out = @fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
        if ($out) {
            // Read binary input stream and append it to temp file
            $in = @fopen($_FILES['file']['tmp_name'], "rb");

            if ($in) {
                while ($buff = fread($in, 4096))
                    fwrite($out, $buff);
            } else
                die('{"OK": 0, "info": "Failed to open input stream."}');

            @fclose($in);
            @fclose($out);

            @unlink($_FILES['file']['tmp_name']);
        } else {
            die('{"OK": 0, "info": "Failed to open output stream."}');
        }

        // Check if file has been uploaded
        if (!$chunks || $chunk == $chunks - 1) {
            // Strip the temp .part suffix off
            rename("{$filePath}.part", $filePath);
            return $filePath;
        } else {
            return null;
        }
    }

}