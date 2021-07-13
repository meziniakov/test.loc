<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/params.php'
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'console\controllers',
    'bootstrap' => ['gii', 'queue'],
    'controllerMap' => [
        'migrate' => [
            'class' => yii\console\controllers\MigrateController::class,
            'migrationPath' => [
                '@console/migrations',
                '@yii/rbac/migrations',
                '@yii/log/migrations',
            ],
        ],
    ],
    'modules' => [
        'gii' => 'yii\gii\Module',
        'db-manager' => [
            'class' => 'bs\dbManager\Module',
            // path to directory for the dumps
            'path' => '@root/backups',
            // list of registerd db-components
            'dbList' => ['db'],
        ],
    ],
    'components' => [
        'queue' => [
            // 'class' => \yii\queue\file\Queue::class,
            'class' => \yii\queue\db\Queue::class,
            // 'path' => '@console/runtime/queue',
            'as log' => \yii\queue\LogBehavior::class,
            'db' => 'db',
            'tableName' => '{{%queue}}', // Имя таблицы
            'channel' => 'default', // Queue channel key
            'mutex' => \yii\mutex\MysqlMutex::class, // Mutex used to sync queries
        ],
    ],
    'bootstrap' => [
        'queue', // Компонент регистрирует свои консольные команды
    ],
    'params' => $params,
];
