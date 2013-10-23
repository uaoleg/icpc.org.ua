<?php

$params = array(

    'emails' => array(
        'info'      => array('address' => 'info@icpc.org.ua', 'name' => 'icpc.org.ua Team'),
        'noreply'   => array('address' => 'info@icpc.org.ua', 'name' => 'icpc.org.ua Team'),
    ),

    'languages' => array(
        'uk'    => 'Українська',
        'ru'    => 'Русский',
        'en'    => 'English',
    ),

    'regexp' => array(
        'notAlphanumericSoft'       => "\!@#$%^&+*=\[\]{}\"\\\\\/|<>\?,~", // Validate user name
        'notAlphanumericShortUrl'   => "\!@#$%^&+*=\[\]{}\"\\\\\/|<>\?,~" . "()'", // Validate short URL
        'notAlphanumericStrong'     => "\!@#$%^&+*=\[\]{}\"\\\\\/|<>\?,~" . "()\-\._'", // Alphanumeric only
    ),

    'version' => 'beta.2013-10-23.1',

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