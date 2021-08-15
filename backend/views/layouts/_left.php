<?php

use backend\models\Log;
use backend\widgets\Menu;

/* @var $this \yii\web\View */
?>
<aside class="main-sidebar">
    <section class="sidebar">
        <?= Menu::widget([
            'options' => ['class' => 'sidebar-menu', 'data-widget' => 'tree'],
            'items' => [
                [
                    'label' => Yii::t('backend', 'Main'),
                    'options' => ['class' => 'header'],
                ],
                [
                    'label' => Yii::t('backend', 'Menu'),
                    'url' => ['/menu/index'],
                    'icon' => '<i class="fa fa-sitemap"></i>',
                    'template' => '<a href="{url}">{icon}<span>{label}</span><span class="pull-right-container"><small class="label pull-right bg-green"></small></span></a>',
                ],
                [
                    'label' => Yii::t('backend', 'Tags'),
                    'url' => ['/tag/index'],
                    'icon' => '<i class="fa fa-tags"></i>',
                ],
                [
                    'label' => Yii::t('backend', 'Парсеры'),
                    'url' => '#',
                    'icon' => '<i class="fa fa-search"></i>',
                    'options' => ['class' => 'treeview'],
                    'items' => [
                        ['label' => Yii::t('backend', 'Места'), 'url' => ['/parser/json/place'], 'icon' => '<i class="fa fa-angle-double-right"></i>'],
                        ['label' => Yii::t('backend', 'События'), 'url' => ['/parser/json/event'], 'icon' => '<i class="fa fa-angle-double-right"></i>'],
                        ['label' => Yii::t('backend', 'Json'), 'url' => ['/parser/json'], 'icon' => '<i class="fa fa-angle-double-right"></i>'],
                        ['label' => Yii::t('backend', 'Xml'), 'url' => ['/parser/index'], 'icon' => '<i class="fa fa-angle-double-right"></i>'],
                        ['label' => Yii::t('backend', 'Генератор обзоров'), 'url' => ['/parser/index/generate-review'], 'icon' => '<i class="fa fa-angle-double-right"></i>'],
                    ],

                ],
                [
                    'label' => Yii::t('backend', 'Cities'),
                    'url' => ['/city'],
                    'icon' => '<i class="fa fa-globe"></i>',
                ],
                [
                    'label' => Yii::t('backend', 'Places'),
                    'url' => '#',
                    'icon' => '<i class="fa fa-map-marker"></i>',
                    'options' => ['class' => 'treeview'],
                    'items' => [
                        ['label' => Yii::t('backend', 'Place'), 'url' => ['/place/index'], 'icon' => '<i class="fa fa-angle-double-right"></i>'],
                        ['label' => Yii::t('backend', 'Place categories'), 'url' => ['/place-category/index'], 'icon' => '<i class="fa fa-angle-double-right"></i>'],
                    ],
                ],
                [
                    'label' => Yii::t('backend', 'Events'),
                    'url' => '#',
                    'icon' => '<i class="fa fa-map-marker"></i>',
                    'options' => ['class' => 'treeview'],
                    'items' => [
                        ['label' => Yii::t('backend', 'Events'), 'url' => ['/event/index'], 'icon' => '<i class="fa fa-angle-double-right"></i>'],
                        ['label' => Yii::t('backend', 'Event categories'), 'url' => ['/event-category/index'], 'icon' => '<i class="fa fa-angle-double-right"></i>'],
                    ],
                ],
                [
                    'label' => Yii::t('backend', 'Content'),
                    'url' => '#',
                    'icon' => '<i class="fa fa-edit"></i>',
                    'options' => ['class' => 'treeview'],
                    'items' => [
                        ['label' => Yii::t('backend', 'Static pages'), 'url' => ['/page/index'], 'icon' => '<i class="fa fa-angle-double-right"></i>'],
                        ['label' => Yii::t('backend', 'Articles'), 'url' => ['/article/index'], 'icon' => '<i class="fa fa-angle-double-right"></i>'],
                        ['label' => Yii::t('backend', 'Article categories'), 'url' => ['/article-category/index'], 'icon' => '<i class="fa fa-angle-double-right"></i>'],
                    ],
                ],
                [
                    'label' => Yii::t('backend', 'System'),
                    'options' => ['class' => 'header'],
                ],
                [
                    'label' => Yii::t('backend', 'Users'),
                    'url' => ['/user/index'],
                    'icon' => '<i class="fa fa-users"></i>',
                    'visible' => Yii::$app->user->can('administrator'),
                ],
                [
                    'label' => Yii::t('backend', 'Other'),
                    'url' => '#',
                    'icon' => '<i class="fa fa-terminal"></i>',
                    'options' => ['class' => 'treeview'],
                    'items' => [
                        [
                            'label' => 'Gii',
                            'url' => ['/gii'],
                            'icon' => '<i class="fa fa-angle-double-right"></i>',
                            'visible' => YII_ENV_DEV,
                        ],
                        ['label' => Yii::t('backend', 'File manager'), 'url' => ['/file-manager/index'], 'icon' => '<i class="fa fa-angle-double-right"></i>'],
                        [
                            'label' => Yii::t('backend', 'DB manager'),
                            'url' => ['/db-manager/default/index'],
                            'icon' => '<i class="fa fa-angle-double-right"></i>',
                            'visible' => Yii::$app->user->can('administrator'),
                        ],
                        [
                            'label' => Yii::t('backend', 'System information'),
                            'url' => ['/phpsysinfo/default/index'],
                            'icon' => '<i class="fa fa-angle-double-right"></i>',
                            'visible' => Yii::$app->user->can('administrator'),
                        ],
                        ['label' => Yii::t('backend', 'Key storage'), 'url' => ['/key-storage/index'], 'icon' => '<i class="fa fa-angle-double-right"></i>'],
                        ['label' => Yii::t('backend', 'Cache'), 'url' => ['/service/cache'], 'icon' => '<i class="fa fa-angle-double-right"></i>'],
                        ['label' => Yii::t('backend', 'Clear assets'), 'url' => ['/service/clear-assets'], 'icon' => '<i class="fa fa-angle-double-right"></i>'],
                        [
                            'label' => Yii::t('backend', 'Logs'),
                            'url' => ['/log/index'],
                            'icon' => '<i class="fa fa-angle-double-right"></i>',
                            'badge' => Log::find()->count(),
                            'badgeOptions' => ['class' => 'label-danger'],
                        ],
                    ],
                ],
            ],
        ]) ?>
    </section>
</aside>
