<?php

namespace common\components;

class Archive extends \CApplicationComponent
{

    /**
     * Compress file
     *
     * @param string $in  File path or directory
     * @param string $out Archive name
     * @return bool
     */
    public function compress($in, $out)
    {
        // Get list of files
        if (is_dir($in)) {
            $fileList = \CFileHelper::findFiles($in);
        } elseif (is_file($in)) {
            $fileList = array($in);
        } else {
            return false;
        }

        // Archive files
        $zip = new \ZipArchive();
        $zip->open($out, \ZipArchive::CREATE);
        foreach ($fileList as $file) {
            $zip->addFile($file);
            $zip->renameName($file, mb_substr($file, mb_strlen($in) + 1));
        }
        $zip->close();

        return true;
    }

}