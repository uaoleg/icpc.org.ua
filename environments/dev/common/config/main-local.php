<?php
return [
    'components' => [
        'db' => [
            'dsn'       => 'mysql:host=localhost;dbname=icpc_dev',
            'username'  => 'root',
            'password'  => '',
        ],
        'dbtests' => [
            'username' => 'codeception',
            'password' => 'fortesting',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
