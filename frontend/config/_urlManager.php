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
        // '/' => 'site/index',
        'cities' => 'site/cities',
        'sitemap.xml' => 'sitemap/index',
        'robots.txt' => 'robots/index',
        'contact' => 'site/contact',
        'ajax-login' => 'site/ajax-login',
        'faq' => 'site/faq',
        'ekskursii' => 'site/ekskursii',
        // Activity
        // 'activity' => 'activity/index',
        // Pages
        'page/<slug>' => 'page/view',
        // Articles
        'article/page/<page>' => 'article/index',
        'article/<slug>' => 'article/view',
        'article/category/<slug>' => 'article/category',
        'article/tag/<slug>' => 'article/tag',
        // Places
        'place/page/<page>' => 'place/index',
        'place/search' => 'place/search',
        'place' => 'place/index',
        // 'place/tags' => 'place/tags',
        'place/tag/<slug>' => 'place/tag',
        'place/<slug>' => 'place/category',
        '//<city>.'.Yii::getAlias('@domain').'/place/<category>/<slug>' => 'place/view',
        'place/<category>/<slug>' => 'place/view',
        // 'place/category/<slug>/page/<page>' => 'place/category',
        'tag/<slug>' => 'place/tag',
        'tag/<slug>/json' => 'place/json',
        'tag/<slug>/address' => 'place/address',
        // '//blog.test.loc/' => 'article/index',
    ],
];
