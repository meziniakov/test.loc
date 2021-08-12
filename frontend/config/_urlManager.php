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
        'cities' => 'site/cities',
        'sitemap' => 'sitemap/index',
        'robots.txt' => 'robots/index',
        // 'contact' => 'site/contact',
        // 'ajax-login' => 'site/ajax-login',
        // 'faq' => 'site/faq',
        'ekskursii' => 'site/ekskursii',
        '<city>/dostoprimechatelnosti' => 'city/dostoprimechatelnosti',
        '<city>/events' => 'city/events',
        '<city>/gidy' => 'city/gidy',
        // '<city>/pogoda' => 'city/pogoda',
        '<city>/place' => 'place/index',
        '/place' => 'place/index',
        '<city>' => 'site/index',
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
        '<city>/place/page/<page>' => 'place/index',
        '<city>/place/search' => 'place/search',
        // 'place/tags' => 'place/tags',
        '<city>place/tag/<slug>' => 'place/tag',
        // '//<city>.'.Yii::getAlias('@domain').'/place/<category>/<slug>' => 'place/view',
        '<city>/place/<slug>' => 'place/category',
        '<city>/place/<category>/<slug>' => 'place/view',
        // 'place/category/<slug>/page/<page>' => 'place/category',
        '<city>/tag/<slug>' => 'place/tag',
        '<city>/tag/<slug>/json' => 'place/json',
        '<city>/tag/<slug>/address' => 'place/address',
        // Events
        '<city>/event/page/<page>' => 'event/index',
        '<city>/event/search' => 'event/search',
        // '<city>/event' => 'event/index',
        // 'event/tags' => 'event/tags',
        '<city>/event/tag/<slug>' => 'event/tag',
        '<city>/event/<slug>' => 'event/category',
        // '//<city>.'.Yii::getAlias('@domain').'/event/<category>/<slug>' => 'event/view',
        '<city>/event/<category>/<slug>' => 'event/view',
        // 'event/category/<slug>/page/<page>' => 'event/category',
        '<city>/tag/<slug>' => 'event/tag',
        '<city>/tag/<slug>/json' => 'event/json',
        '<city>/tag/<slug>/address' => 'event/address',
    ],
];
