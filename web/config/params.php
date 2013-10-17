<?php

$params = array(

    'itemPerPage' => 10,

    'jwplayer' => array(
        'key' => 'N4cJT71ikhF/LseSGN+QMmCjrwo1101uv1h6KA==',
    ),

    'recaptcha' => array(
        'privateKey' => '6LflltkSAAAAAJkBYNtv4T-J_JVbUDhRfT_SrzHp',
    ),

);

// Environment configuration
$file = __DIR__ . '/env/' . APP_ENV . '/params.php';
if (is_file($file)) {
    $params = \CMap::mergeArray($params, require($file));
}

// Local configuration
$file = __DIR__ . '/local/params.php';
if (is_file($file)) {
    $params = \CMap::mergeArray($params, require($file));
}

return $params;