<?php

$params = array(

    'itemPerPage' => 10,

    'jwplayer' => array(
        'key' => 'N4cJT71ikhF/LseSGN+QMmCjrwo1101uv1h6KA==',
    ),

    'recaptcha.publicKey' => '6LdB1ecSAAAAAH8JXgEzHGAw9UilNsNZLH9qikFJ',
    'recaptcha.language'  => 'en',
    'recaptcha.theme'     => 'white',

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