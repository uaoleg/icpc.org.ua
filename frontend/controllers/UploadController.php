<?php

namespace frontend\controllers;

use \common\models\Document;
use \common\models\News;
use \common\models\Team;
use \common\models\Result;
use \common\models\UploadedFile;
use \common\models\User;
use \yii\helpers\Url;
use \Sunra\PhpSimple\HtmlDomParser;

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
        $uploadedFile = $this->_processFile(true);
        if (!$uploadedFile) {
            return;
        }

        // Get params
        $title = \yii::$app->request->get('title');
        $desc  = \yii::$app->request->get('desc');
        $type  = \yii::$app->request->get('type');
        if (empty($title)) {
            $title = \yii::$app->request->get('name');
        }

        // Define file type
        $fileExt = mb_strtolower(mb_substr($uploadedFile->filename, strrpos($uploadedFile->filename, '.') + 1));

        // Create document
        $document = new Document();
        $document->setAttributes(array(
            'title'     => $title,
            'desc'      => $desc,
            'type'      => $type,
            'fileExt'   => $fileExt,
            'content'   => $uploadedFile->getContent(),
        ), false);
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
        $uploadedFile = $this->_processFile(true);
        if (!$uploadedFile) {
            return;
        }

        // Get params
        $geo    = \yii::$app->request->get('geo');
        $year   = (int)date('Y');
        $resultsViewParams = array('year' => $year);

        // Create parser object
        \yii::import('common.lib.HtmlDomParser.*');
        require_once('HtmlDomParser.php');
        $parser = new HtmlDomParser();
        $html = $parser->str_get_html($uploadedFile->getBytes());
        $uploadedFile->delete();

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
            $teamName = $tr->find('.st_team', 0)->plaintext;
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
                $tmp = $output = preg_replace('!\s+!', ' ', trim($prob->plaintext));
                if ($tmp[0] === '-') {
                    $tasksTries[$letters[$i]] = (int)$tmp; // '-1' => -1, '-2' => -2, ...
                    $tasksTime[$letters[$i]]  = null;
                } elseif ($tmp[0] === '+') {
                    $res = explode(' ', $tmp);
                    $tasksTries[$letters[$i]] = $res[0] + 1; // '+' => 1, '+1' => 2, ...
                    $time = preg_replace('/[()]/', '', $res[1]);
                    list($timeHours, $timeMins) = explode(':', $time);
                    $tasksTime[$letters[$i]]  = $timeHours * SECONDS_IN_HOUR + $timeMins * SECONDS_IN_MINUTE;
                } else {
                    $tasksTries[$letters[$i]] = null;
                    $tasksTime[$letters[$i]]  = null;
                }
            }

            $place = $tr->find('.st_place', 0)->plaintext;
            if ($place != '&nbsp;') {
                // Create result
                $result = new Result();
                $result->setAttributes(array(
                    'teamId'    => (isset($team)) ? $team->id : null,
                    'year'      => $year,
                    'phase'     => $phase,
                    'geo'       => $geo,
                    'place'     => $place,
                    'placeText' => $place,
                    'tasksTries'=> $tasksTries,
                    'tasksTime' => $tasksTime,
                    'total'     => $tr->find('.st_total', 0)->plaintext,
                    'penalty'   => $tr->find('.st_pen', 0)->plaintext,
                ), false);

                if (!$result->save()) {
                    return $this->renderJson(array(
                        'errors' => true,
                        'message' => \yii::t('app', 'Not all results were saved!')
                    ));
                    \yii::$app->end();
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
            $uploadedFile = $this->_processFile();
            if (!$uploadedFile) {
                return;
            }

            $filePath = \yii::getAlias('@common/runtime');
            $fileName = array_pop(explode('/', $uploadedFile->filename));
            $file = fopen($filePath . '/' . $fileName, 'w');
            fwrite($file, $uploadedFile->getBytes());
            fclose($file);

            $newFileName = array_shift(explode('.', $fileName)) . '.jpg';
            \yii::$app->image->scale(
                $filePath . '/' . $fileName,
                $filePath . '/' . $newFileName,
                array(
                    'max_width' => 2000,
                    'max_height' => 2000,
                    'min_width' => 100,
                    'min_height' => 100,
                )
            );

            // Delete previous file
            $uploadedFile->delete();

            // Create a new scaled and converted file
            $newUploadedFile = new UploadedFile();
            $newUploadedFile->setAttributes(array(
                'filename' => $filePath . '/' . $fileName,
            ), false);
            $newUploadedFile->save();

            $image = new News\Image();
            $image->fileName = mb_strtolower(\yii::$app->request->get('uniqueName'));
            $image->newsId = (!empty($newsId)) ? $newsId : null;
            $image->userId = \yii::$app->user->id;
            $image->content = $uploadedFile->getContent();
            $image->save();

            // Delete temporary files
            unlink($filePath . '/' . $fileName);
            if (file_exists($filePath . '/' . $newFileName)) {
                unlink($filePath . '/' . $newFileName);
            }

            return $this->renderJson(array(
                'errors' => false,
                'id' => $image->id
            ));
        } else {
            return $this->renderJson(array(
                'errors' => true,
                'message' => \yii::t('app', 'There are more than {0} images for this news. You cannot add any more.', News::MAX_IMAGES_COUNT),
            ));
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
        $uploadedFile = $this->_processFile();
        if (!$uploadedFile) {
            return;
        }

        $filePath = \yii::getAlias('@common/runtime');
        $fileName = array_pop(explode('/', $uploadedFile->filename));
        $file = fopen($filePath . '/' . $fileName, 'w');
        fwrite($file, $uploadedFile->getBytes());
        fclose($file);

        $newFileName = array_shift(explode('.', $fileName)) . '.jpg';
        \yii::$app->image->scale(
            $filePath . '/' . $fileName,
            $filePath . '/' . $newFileName,
            array(
                'max_width' => 2000,
                'max_height' => 2000,
                'min_width' => 100,
                'min_height' => 100,
            )
        );

        // Delete previous file
        $uploadedFile->delete();

        // Create a new scaled and converted file
        $newUploadedFile = new UploadedFile();
        $newUploadedFile->setAttributes(array(
            'filename' => $filePath . '/' . $fileName,
        ), false);
        $newUploadedFile->save();

        // Delete old photo if it exists
        if ($user->photo !== null) {
            $user->photo->delete();
        }

        // Create document
        $photo = new User\Photo();
        $photo->setAttributes(array(
            'fileName' => mb_strtolower(\yii::$app->request->get('uniqueName')),
            'userId'   => $userId,
            'content'   => $newUploadedFile->getContent(),
        ), false);
        $photo->save();

        // Delete temporary files
        unlink($filePath . '/' . $fileName);
        if (file_exists($filePath . '/' . $newFileName)) {
            unlink($filePath . '/' . $newFileName);
        }

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
    protected function _getUploadDir()
    {
        $dir = ini_get('upload_tmp_dir') ? ini_get('upload_tmp_dir') : sys_get_temp_dir();
        $dir .= '/icpc/';
        return $dir;
    }

    /**
     * Process file upload
     *
     * @return UploadedFile
     */
    protected function _processFile()
    {
        // Set headers
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        // Settings
        $targetDir = $this->_getUploadDir();

        // Get parameters
        $chunkNumber = (int)\yii::$app->request->get('chunk');
        $chunkCount  = (int)\yii::$app->request->get('chunks');
        $fileName    = \yii::$app->request->get('uniqueName', '');

        // Clean the fileName for security reasons
        $fileName = preg_replace('/[^\w\._]+/', '_', $fileName);

        // Make sure the fileName is unique but only if chunking is disabled
        if (($chunkCount < 2) && (file_exists($targetDir . $fileName))) {
            $ext = strrpos($fileName, '.');
            $fileName_a = mb_substr($fileName, 0, $ext);
            $fileName_b = mb_substr($fileName, $ext);

            $count = 1;
            while (file_exists($targetDir . $fileName_a . '_' . $count . $fileName_b)) {
                $count++;
            }

            $fileName = $fileName_a . '_' . $count . $fileName_b;
        }

        $filePath = $targetDir . $fileName;

        // Create target dir
        if (!file_exists($targetDir)) {
            mkdir($targetDir);
        }

        // Look for the content type header
        if (isset($_SERVER["HTTP_CONTENT_TYPE"])) {
            $contentType = $_SERVER["HTTP_CONTENT_TYPE"];
        }

        if (isset($_SERVER["CONTENT_TYPE"])) {
            $contentType = $_SERVER["CONTENT_TYPE"];
        }

        // Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
        if (strpos($contentType, "multipart") !== false) {
            if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
                rename($_FILES['file']['tmp_name'], $filePath);
            } else {
                return $this->renderJson(array(
                    'error' => array(
                        'code'      => 103,
                        'message'   => \yii::t('app', 'Failed to move uploaded file.'),
                    ),
                ));
                \yii::$app->end();
            }
        } else {

            // Write uploaded chunks to the system
            if ($chunkNumber > 0) {
                $uploadedFile = UploadedFile::model()->findByAttributes(array(
                    'filename' => $filePath,
                ));
                if ($uploadedFile !== null) {
                    $uploadedFile->write();
                }
            }

            // Open temp file
            $out = fopen($filePath, $chunkNumber == 0 ? "wb" : "ab");
            if ($out) {
                // Read binary input stream and append it to temp file
                $in = fopen("php://input", "rb");
                if ($in) {
                    while ($buff = fread($in, 4096)) {
                        fwrite($out, $buff);
                    }
                } else {
                    return $this->renderJson(array(
                        'error' => array(
                            'code'      => 101,
                            'message'   => \yii::t('app', 'Failed to open input stream.'),
                        ),
                    ));
                    \yii::$app->end();
                }
                fclose($in);
                fclose($out);
            } else {
                return $this->renderJson(array(
                    'error' => array(
                        'code'      => 102,
                        'message'   => \yii::t('app', 'Failed to open output stream.'),
                    ),
                ));
                \yii::$app->end();
            }
        }

        // Save chunks to DB
        $uploadedFile = new UploadedFile();
        $uploadedFile->setAttributes(array(
            'filename' => $filePath,
        ), false);
        $uploadedFile->save();

        // Delete temp file
        unlink($filePath);

        // Check if file has been uploaded
        if ((!$chunkCount) || ($chunkNumber == $chunkCount - 1)) {

            // Mark file as uploaded
            $modifier = new \EMongoModifier();
            $modifier->addModifier('uploadCompleted', 'set', true);
            $criteria = new \EMongoCriteria();
            $criteria->addCond('filename', '==', $filePath);
            UploadedFile::model()->updateAll($modifier, $criteria);

            // Return uploaded file
            return $uploadedFile;

        } else {
            return null;
        }
    }

}