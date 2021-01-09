<?php

$config = [
    'name'=>'Surf City',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'extensions' => require __DIR__ . '/../../vendor/yiisoft/extensions.php',
    'timeZone' => env('TIMEZONE'),
    'sourceLanguage' => 'en-US',
    'language' => env('LANGUAGE'),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules' => [
        // 'gallery' => [
        //     'class' => 'dvizh\gallery\Module',
        //     'imagesStorePath' => '@storage/images/original', //path to origin images
        //     // 'imagesStorePath' => dirname(dirname(__DIR__)).'/frontend/web/images/store', //path to origin images
        //     'imagesCachePath' => '@storage/images/cache', //path to resized copies
        //     // 'imagesCachePath' => dirname(dirname(__DIR__)).'/frontend/web/images/cache', //path to resized copies
        //     'graphicsLibrary' => 'GD',
        //     'placeHolderPath' => '@storage/avatars/5fa3094faef6d.jpg',
        //     'adminRoles' => ['administrator', 'admin', 'superadmin'],
        // ],
        'yii2images' => [
            'class' => 'alex290\yii2images\Module',
            'imagesStorePath' => '@storage/img/original', //path to origin images
            'imagesCachePath' => '@storage/img/resize', //path to resized copies
            'graphicsLibrary' => 'GD', //but really its better to use 'Imagick' 
            'placeHolderPath' => '@storage/images/placeHolder.png', // if you want to get placeholder when image not exists, string will be processed by Yii::getAlias
            'imageCompressionQuality' => 100, // Optional. Default value is 85.
        ],
    ],
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => env('DB_DSN'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'tablePrefix' => env('DB_TABLE_PREFIX'),
            'charset' => 'utf8',
            'enableSchemaCache' => YII_ENV_PROD,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'linkAssets' => env('LINK_ASSETS'),
            'appendTimestamp' => YII_ENV_DEV,
        ],
        'log' => [
            'traceLevel' => YII_ENV_DEV ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error', 'warning'],
                    'except' => ['yii\web\HttpException:*', 'yii\i18n\I18N\*'],
                    'prefix' => function () {
                        $url = !Yii::$app->request->isConsoleRequest ? Yii::$app->request->getUrl() : null;

                        return sprintf('[%s][%s]', Yii::$app->id, $url);
                    },
                    'logVars' => [],
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'fileMap' => [
                        'common' => 'common.php',
                        'backend' => 'backend.php',
                        'frontend' => 'frontend.php',
                    ],
                ],
            ],
        ],
        'keyStorage' => [
            'class' => 'common\components\keyStorage\KeyStorage',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => YII_ENV_DEV,
        ],
        'cache' => [
            'class' => YII_ENV_DEV ? 'yii\caching\DummyCache' : 'yii\caching\FileCache',
        ],
    ],
];

return $config;
