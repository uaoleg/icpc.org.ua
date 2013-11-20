<?php

namespace web\controllers;

use \common\models\Document;
use common\models\Team;
use \common\models\UploadedFile;
use \common\models\Result;

class UploadController extends \web\ext\Controller
{

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
     * Link uploaded file with document
     *
     * @param mixed $file
     * @param UploadedFile $uploadedFile
     */
    protected function _linkUploadedFile($file, UploadedFile $uploadedFile)
    {
        // Update object in DB
        $criteria = new \EMongoCriteria();
        $criteria->addCond('filename', '==', $uploadedFile->filename);
        $modifier = new \EMongoModifier();
        $modifier->addModifier('uniqueId', 'set', $file->getUniqueId());
        UploadedFile::model()->updateAll($modifier, $criteria);

        // Update object
        $uploadedFile->uniqueId = $file->getUniqueId();
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
        $chunkNumber = (int)$this->request->getParam('chunk');
        $chunkCount  = (int)$this->request->getParam('chunks');
        $fileName    = $this->request->getParam('uniqueName', '');

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
                $this->renderJson(array(
                    'error' => array(
                        'code'      => 103,
                        'message'   => \yii::t('app', 'Failed to move uploaded file.'),
                    ),
                ));
                \yii::app()->end();
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
                    $this->renderJson(array(
                        'error' => array(
                            'code'      => 101,
                            'message'   => \yii::t('app', 'Failed to open input stream.'),
                        ),
                    ));
                    \yii::app()->end();
                }
                fclose($in);
                fclose($out);
            } else {
                $this->renderJson(array(
                    'error' => array(
                        'code'      => 102,
                        'message'   => \yii::t('app', 'Failed to open output stream.'),
                    ),
                ));
                \yii::app()->end();
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
        $title = $this->request->getParam('title');
        $desc  = $this->request->getParam('desc');
        $type  = $this->request->getParam('type');
        if (empty($title)) {
            $title = $this->request->getParam('name');
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
        ), false);
        $document->save();
        $this->_linkUploadedFile($document, $uploadedFile);

        // Render item HTML
        $html = '';

        // Render json
        $this->renderJson(array(
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
        $phase  = $this->request->getParam('phase');
        $this->_parseResults($uploadedFile, $phase);
        $uploadedFile->delete();
    }

    /**
     * Method which parses downloaded results html file
     * @param UploadedFile $file
     * @param int          $phase
     */
    protected function _parseResults(UploadedFile $file, $phase)
    {
        $v = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // Import HTML DOM Parser
        \yii::import('common.lib.HtmlDomParser.*');
        require_once('HtmlDomParser.php');

        // Create parser object
        $parser = new \Sunra\PhpSimple\HtmlDomParser();
        $html = $parser->str_get_html($file->getBytes());

        $isFirstLine = true;
        foreach ($html->find('tr') as $tr) {
            if ($isFirstLine) {
                // headings of table
                $isFirstLine = false;
            } else {
                // all the standings
                $teamName = $tr->find('.st_team', 0)->plaintext;
                $team     = Team::model()->findByAttributes(array(
                    'name' => $teamName
                ));
                if (isset($team)) {
                    $result = new Result();

                    $result->place  = $tr->find('.st_place', 0)->plaintext;
                    $result->teamId = (string)$team->_id;
                    $result->phase  = $phase;

                    $i = 0;
                    foreach ($tr->find('.st_prob') as $prob) {
                        $tmp = $output = preg_replace('!\s+!', ' ', trim($prob->plaintext));

                        if ($tmp[0] === '-') {
                            $result->tasksTries[$v[$i]] = (int)$tmp;
                            $result->tasksTime[$v[$i]]  = null;
                        } elseif ($tmp[0] === '+') {
                            $res = explode(' ', $tmp);

                            $tries = substr($res[0], 1);
                            $tries = (isset($tries)) ? ((int)$tries + 1) : 1;
                            $result->tasksTries[$v[$i]] = $tries;

                            $time = preg_replace('/[()]/', '', $res[1]);
                            $time = explode(':', $time);
                            $result->tasksTime[$v[$i]]  = $time[0] * SECONDS_IN_HOUR + $time[1] * SECONDS_IN_MINUTE;
                        } else {
                            $result->tasksTries[$v[$i]] = null;
                            $result->tasksTime[$v[$i]]  = null;
                        }
                        $i++;
                    }

                    $result->total   = $tr->find('.st_total', 0)->plaintext;
                    $result->penalty = $tr->find('.st_pen', 0)->plaintext;

                    $result->save();
                }
            }
        }
    }

}