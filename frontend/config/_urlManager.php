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
        // '' => 'site/index',
        '//blog.surf-city.ru/' => 'article/index',
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
        'company/page/<page>' => 'company/index',
        'company/json' => 'company/json',
        'company/address' => 'company/address',
        // 'company/searching' => 'company/searching',
        'company/search' => 'company/search',
        'company' => 'company/index',
        // 'company/tags' => 'company/tags',
        'company/<slug>' => 'company/view',
        'company/category/<slug>/page/<page>' => 'company/category',
        'company/category/<slug>' => 'company/category',
        'tag/<slug>' => 'company/tag',
        'tag/<slug>/json' => 'company/json',
        'tag/<slug>/address' => 'company/address',
        '//blog.test.loc/' => 'article/index',

    ],
];
