<?php

return [
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

    'user.passwordResetTokenExpire' => SECONDS_IN_WEEK,

    'yearFirst' => 2013, // News, Results, etc.

    'version' => 'phase_16.1.3',
];
