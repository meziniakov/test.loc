<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\models\NavItem;
use lo\modules\noty\Wrapper;
use frontend\widgets\LoginFormWidget;
use frontend\widgets\SignupFormWidget;
use yii\widgets\Menu;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <?php $this->registerJsFile('/reveal/js/gtm.js') ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="preconnect" href="//api-maps.yandex.ru">
    <link rel="dns-prefetch" href="//api-maps.yandex.ru">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="preload" as="image" href="<?= Yii::getAlias('@storageUrl') ?>/theme/logo.svg" imagesrcset="<?= Yii::getAlias('@storageUrl') ?>/theme/logo.svg 400w, <?= Yii::getAlias('@storageUrl') ?>/theme/logo.svg 800w, <?= Yii::getAlias('@storageUrl') ?>/theme/logo.svg 1600w" imagesizes="50vw">
    <link rel="preload" as="image" href="<?= Yii::getAlias('@storageUrl') ?>/img/surf-city_main.jpeg" imagesrcset="<?= Yii::getAlias('@storageUrl') ?>/img/surf-city_main.jpeg 400w, <?= Yii::getAlias('@storageUrl') ?>/img/surf-city_main.jpeg 800w, surf-city_main.jpeg 1600w" imagesizes="50vw">
</head>

<?= Html::beginTag('body', [
    'class' => implode(' ', array_filter([
        'hold-transition',
        Yii::$app->keyStorage->get('frontend.theme-skin', 'purple-skin'),
    ])),
]) ?>
<?php $this->beginBody() ?>
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N6VTPSM" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- <div id="preloader">
        <div class="preloader"><span></span><span></span></div>
    </div> -->

<?php
$menuItems = [
    // [
    //     'label' => Yii::t('frontend', 'Users'),
    //     'url' => ['/account/default/users'],
    //     'visible' => !Yii::$app->user->isGuest,
    // ],
];
// if (Yii::$app->user->isGuest) {
//     $menuItems[] = ['label' => Yii::t('frontend', 'Login'), 'url' => ['/account/sign-in/login']];
// } else {
//     $menuItems[] = [
//         'label' => Yii::$app->user->identity->username,
//         'url' => '#',
//         // 'template' => '<a href="{url}" data-toggle="dropdown">{label}</a>',
//         'options' => ['class' => 'nav-item dropdown'],
//         // 'lastItemCssClass' => ['class' => 'navbar-nav-more dropdown'],
//         'items' => [
//             ['label' => Yii::t('frontend', 'Settings'), 'url' => ['/account/default/settings']],
//             [
//                 'label' => Yii::t('frontend', 'Backend'),
//                 'url' => env('BACKEND_URL'),
//                 'linkOptions' => ['target' => '_blank'],
//                 'visible' => Yii::$app->user->can('administrator'),
//             ],
//             [
//                 'label' => Yii::t('frontend', 'Logout'),
//                 'url' => ['/account/sign-in/logout'],
//                 'linkOptions' => ['data-method' => 'post'],
//             ],
//         ],
//     ];
// }
?>

<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-white mb-0">
    <div class="container">
        <?= Html::a(Html::img(Yii::getAlias('@storageUrl') . '/theme/logo.svg', ['alt' => 'Логотип Surf-City.ru']), ['/']) ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText" data-nav="priority-1">
            <?php
            echo Menu::widget([
                'options' => ['class' => 'nav navbar-nav'], //menu core-nav-list    mr-auto mt-2 mt-lg-0 menu core-nav-list
                'submenuTemplate' => "\n<ul class=\"dropdown-menu\" aria-labelledby=\"navbarDropdown\">\n{items}\n</ul>\n",
                'items' => ArrayHelper::merge(NavItem::getMenuItems(), $menuItems)
            ]);
            ?>
        </div>
        <div id="navbarText">
            <ul class="attributes attributes-desk ad-two">
                <!-- <li class="log-icon lg-ic"><a href="#" data-toggle="modal" data-target="#login" class="rt-log"><i class="ti-import"></i></a></li> -->
            </ul>
        </div>
    </div>
</nav>

<div class="clearfix"></div>
<div class="container">
    <?= Wrapper::widget(); ?>
</div>
<?= Breadcrumbs::widget([
    'encodeLabels' => false,
    'tag' => 'div',
    'options' => [
        'class' => 'breadcrumb',
    ],
    'homeLink' => [
        'label' => '<i class="ti-home"></i>',
        'url' => Yii::$app->homeUrl,
        'title' => 'Главная',
    ],
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?>

<?= $content ?>

<footer class="dark-footer skin-dark-footer">
    <div>
        <div class="container">
            <div class="row">

                <div class="col-lg-4 col-md-6">
                    <div class="footer-widget">
                        <?= Html::a(Html::img(Yii::getAlias('@storageUrl') . '/theme/g-logo-light.svg', ['alt' => 'Логотип Surf-City.ru', 'class' => 'img-fluid f-logo']), ['/']) ?>
                        <ul class="footer-bottom-social">
                            <li><a href="#"><i class="ti-facebook"></i></a></li>
                            <li><a href="#"><i class="ti-twitter"></i></a></li>
                            <li><a href="#"><i class="ti-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
                <!-- <div class="col-lg-2 col-md-4">
                            <div class="footer-widget">
                                <h4 class="widget-title">Useful links</h4>
                                <ul class="footer-menu">
                                    <li><a href="about-us.html">About Us</a></li>
                                    <li><a href="faq.html">FAQs Page</a></li>
                                    <li><a href="checkout.html">Checkout</a></li>
                                    <li><a href="login.html">Login</a></li>
                                </ul>
                            </div>
                        </div> -->

                <!-- <div class="col-lg-2 col-md-4">
                            <div class="footer-widget">
                                <h4 class="widget-title">Developers</h4>
                                <ul class="footer-menu">
                                    <li><a href="booking.html">Booking</a></li>
                                    <li><a href="stays.html">Stays</a></li>
                                    <li><a href="adventures.html">Adventures</a></li>
                                    <li><a href="author-detail.html">Author Detail</a></li>
                                </ul>
                            </div>
                        </div> -->

                <div class="col-lg-2 col-md-4">
                    <div class="footer-widget">
                        <h4 class="widget-title">Навигация</h4>
                        <ul class="footer-menu">
                            <li><?= Html::a('Места', ['place/index']) ?></li>
                            <li><?= Html::a('Статьи', ['article/index']) ?></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-2 col-md-4">
                    <div class="footer-widget">
                        <h4 class="widget-title">Поддержка</h4>
                        <ul class="footer-menu">
                            <li><?= Html::a('Политика конфиденциальности', ['page/view', 'slug' => 'privacy_policy']) ?></li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12 col-md-12 text-center">
                    <p class="mb-0">© 2019 Surf-City. All Rights Reserved</p>
                </div>
            </div>
        </div>
    </div>
</footer>
<a id="back2Top" class="top-scroll" title="Вверх" href="#"><i class="ti-arrow-up"></i></a>
<?php echo LoginFormWidget::widget([]); ?>
<?php echo SignupFormWidget::widget([]); ?>
<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>