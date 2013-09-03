<?php
$docRoot = $_SERVER['DOCUMENT_ROOT'] . '/';
$baseUrl = $_SERVER['PHP_SELF'];
$baseUrl = explode('/', $baseUrl);
unset($baseUrl[count($baseUrl) - 1]);
unset($baseUrl[count($baseUrl) - 1]);
unset($baseUrl[0]);
$baseUrl = implode('/', $baseUrl) . '/';

$pathJsList    = array();
$pathJsList[]  = $baseUrl . 'js/';
$pathCssList   = array();
if (isset($_GET['theme'])) {
    $pathCssList[] = $baseUrl . '/themes/' . $_GET['theme'] . '/css/';
} else {
    $pathCssList[] = $baseUrl . '/css/';
}

function getFiles($directory, $exempt = array('.', '..', '.ds_store', '.svn', 'tiny_mce'), &$files = array())
{
    $dirList = array();
    $handle = opendir($directory);
    while (false !== ($resource = readdir($handle))) {
        if (!in_array(strtolower($resource), $exempt)) {
            if (is_dir($directory . $resource . '/')) {
                $dirList[] = $directory . $resource . '/';
            } else {
                $files[] = $directory . $resource;
            }
        }
    }
    foreach ($dirList as $dir) {
        array_merge($files, getFiles($dir, $exempt, $files));
    }
    closedir($handle);
    return $files;
}

/**
 * Application JS group
 */
$js = array();
foreach ($pathJsList as $pathJs) {
    if (is_dir($docRoot.$pathJs)) {
        $fileList = getFiles($docRoot.$pathJs);
    } elseif (is_file($docRoot.$pathJs)) {
        $fileList = array($docRoot.$pathJs);
    } else {
        continue;
    }
    foreach ($fileList as $file) {
        if (is_file($file)) {
            $fileName = strtolower(substr($file, strrpos($file, '/') + 1));
            if ($fileName[0] === '!') continue;
            $ext = strtolower(substr($file, strrpos($file, '.') + 1));
            $filePath = substr($file, strlen($docRoot));
            if (in_array('//'.$filePath, $js)) continue;
            if ($ext == 'js') $js[] = '//'.$filePath;
        }
    }
}

/**
 * Application CSS group
 */
$css = array();
foreach ($pathCssList as $pathCss) {
    if (is_dir($docRoot.$pathCss)) {
        $fileList = getFiles($docRoot.$pathCss);
    } elseif (is_file($docRoot.$pathCss)) {
        $fileList = array($docRoot.$pathCss);
    } else {
        continue;
    }
    foreach ($fileList as $file) {
        if (is_file($file)) {
            $fileName = strtolower(substr($file, strrpos($file, '/') + 1));
            if ($fileName[0] === '!') continue;
            $ext = strtolower(substr($file, strrpos($file, '.') + 1));
            $filePath = substr($file, strlen($docRoot));
            if (in_array('//'.$filePath, $css)) continue;
            if ($ext == 'css') $css[] = '//'.$filePath;
        }
    }
}

/**
 * Groups configuration for default Minify implementation
 * @package Minify
 */

/**
 * You may wish to use the Minify URI Builder app to suggest
 * changes. http://yourdomain/min/builder/
 **/

return array(
    'js'        => $js,
    'css'       => $css,

    // custom source example
    /*'js2' => array(
        dirname(__FILE__) . '/../min_unit_tests/_test_files/js/before.js',
        // do NOT process this file
        new Minify_Source(array(
            'filepath' => dirname(__FILE__) . '/../min_unit_tests/_test_files/js/before.js',
            'minifier' => create_function('$a', 'return $a;')
        ))
    ),//*/

    /*'js3' => array(
        dirname(__FILE__) . '/../min_unit_tests/_test_files/js/before.js',
        // do NOT process this file
        new Minify_Source(array(
            'filepath' => dirname(__FILE__) . '/../min_unit_tests/_test_files/js/before.js',
            'minifier' => array('Minify_Packer', 'minify')
        ))
    ),//*/
);