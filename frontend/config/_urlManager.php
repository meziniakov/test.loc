<?php

return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        // Index page
        // '' => 'site/index',
        '//<city>.test.loc/' => 'company/test',
        '//<city>.surf-city.ru/' => 'company/test',
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
        'company' => 'company/index',
        // 'company/tags' => 'company/tags',
        'company/<slug>' => 'company/view',
        'company/category/<slug>/page/<page>' => 'company/category',
        'company/category/<slug>' => 'company/category',
        'tag/<slug>' => 'company/tag',
        'tag/<slug>/json' => 'company/json',
        'tag/<slug>/address' => 'company/address',
    ],
];
