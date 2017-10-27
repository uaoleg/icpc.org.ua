<?php

return [
    'id' => 'app-console-tests',
    'basePath' => dirname(__DIR__),
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'mysql:host=localhost;dbname=icpc_tests',
            'username' => 'codeception',
            'password' => 'fortesting',
        ],
    ],
];
