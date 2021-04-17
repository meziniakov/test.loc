<?php

use yii\web\UrlNormalizer;

return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'normalizer' => [
        'class' => 'yii\web\UrlNormalizer',
        'action' => UrlNormalizer::ACTION_REDIRECT_TEMPORARY,
    ],
    'rules' => [
        // Index page
        // '/' => 'site/index',
        // '//<controller:\w+>/<action:\w+>/*.test.loc/' => '<controller>/<action>',
        // '<controller:\w+>/<action:\w+>/*'=>'<controller>/<action>',
        // '//blog.surf-city.ru/' => 'article/index',
        // '//blog.test.loc/' => 'article/index',
        // '//<city>.test.loc/' => 'site/index',
        // '//<city:\w+>.<domain:\w+>.<ru:\w+>/' => 'site/contact',
        'sitemap' => 'sitemap/index',
        'contact' => 'site/contact',
        'ajax-login' => 'site/ajax-login',
        'faq' => 'site/faq',
        // Pages
        'page/<slug>' => 'page/view',
        // Articles
        'article/page/<page>' => 'article/index',
        'article/index' => 'article/index',
        'article/<slug>' => 'article/view',
        'article/category/<slug>' => 'article/category',
        'article/tag/<slug>' => 'article/tag',
        // Companies
        'place/page/<page>' => 'place/index',
        'place/json' => 'place/json',
        'place/address' => 'place/address',
        'place/search' => 'place/search',
        'place' => 'place/index',
        'place/tags' => 'place/tags',
        // 'place/<slug>' => 'place/view',
        'place/<slug>' => 'place/category',
        '//<city>.'.Yii::getAlias('@domain').'/place/<category>/<slug>' => 'place/view',

        // 'place/category/<slug>/page/<page>' => 'place/category',
        'tag/<slug>' => 'place/tag',
        'tag/<slug>/json' => 'place/json',
        'tag/<slug>/address' => 'place/address',
        '//blog.test.loc/' => 'article/index',

    ],
];
