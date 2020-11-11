<?php

return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        // Index page
        // '' => 'site/index',
        'http://<city>.test.loc/' => 'company/test',
        'http://msk.test.loc/' => 'company/index',
        'http://tmk.test.loc/' => 'company/index',
        'contact' => 'site/contact',
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
        'company' => 'company/index',
        'company/tags' => 'company/tags',
        'company/<slug>' => 'company/view',
        'company/category/<slug>' => 'company/category',
        'tag/<slug>' => 'company/tag',
        'tag/<slug>/json' => 'company/json',
    ],
];
