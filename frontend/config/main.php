<?php
use yii\web\NotFoundHttpException;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/params.php'
);

$config = [
    'id' => 'app-frontend',
    'homeUrl' => Yii::getAlias('@frontendUrl'),
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'account' => [
            'class' => 'frontend\modules\account\Module',
        ],
        'noty' => [
            'class' => 'lo\modules\noty\Module',
        ],
        // 'gallery' => [
        //     'class' => 'dvizh\gallery\Module',
        //     'imagesStorePath' => '@storage/images/original', //path to origin images
        //     'imagesCachePath' => '@storage/images/cache', //path to resized copies
        //     'graphicsLibrary' => 'GD',
        //     'placeHolderPath' => '@storage/img/placeholder.svg',
        //     // 'adminRoles' => ['administrator', 'admin', 'superadmin'],
        // ],
    ],
    'components' => [
        'city' => [
            'class' => 'frontend\components\CityComponent'
        ],
        'tripster' => [
            'class' => 'frontend\components\TripsterComponent'
        ],
        'seo' => [
            'class' => 'frontend\components\SeoComponent'
        ],
        'request' => [
            'cookieValidationKey' => env('BACKEND_COOKIE_VALIDATION_KEY'),
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'loginUrl'=>['/account/sign-in/login'],
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true, 'path' => '/', 'domain' => '.' . Yii::getAlias('@domain')],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'app-frontend',
            'cookieParams' => [
                'domain' => '.' . Yii::getAlias('@domain'),
            ]
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => require __DIR__ . '/_urlManager.php',
        'cache' => require __DIR__ . '/_cache.php',
    ],
    'on beforeAction' => function ($event) {
        if (count(explode(".", Yii::$app->request->serverName)) > 2) {
            return Yii::$app->params['city'] = explode(".", Yii::$app->request->serverName)[0];
        }
    },
    'as beforeAction' => [
        'class' => 'common\behaviors\LastActionBehavior',
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
    ];
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '*.*.*.*'],
    ];
}

if (YII_ENV_PROD) {
    // maintenance mode
    $config['bootstrap'] = ['maintenance'];
    $config['components']['maintenance'] = [
        'class' => 'common\components\maintenance\Maintenance',
        'enabled' => env('MAINTENANCE_MODE'),
        'route' => 'maintenance/index',
        'message' => env('MAINTENANCE_MODE_MESSAGE'),
        // year-month-day hour:minute:second
        'time' => env('MAINTENANCE_MODE_TIME'), // время окончания работ
    ];
}

return $config;
