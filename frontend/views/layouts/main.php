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
    <style>
        * {
            outline: none
        }

        body {
            background: #ffffff;
            color: #797d8a;
            font-size: 16px;
            font-family: 'Muli', sans-serif;
            margin: 0;
            overflow-x: hidden !important;
            font-weight: 400
        }

        html {
            position: relative;
            min-height: 100%;
            background: #ffffff
        }

        a {
            color: #2D3954;
            text-decoration: none;
            background-color: transparent;
            -webkit-text-decoration-skip: objects
        }

        .img-responsive {
            width: 100%;
            height: auto;
            display: inline-block
        }

        section {
            padding: 40px 0 40px;
            position: relative
        }

        p {
            line-height: 1.8
        }

        .full-width {
            width: 100%
        }

        p,
        ul {
            margin: 0 0 10px
        }

        h1,
        h2,
        h4 {
            color: #2D3954;
            font-weight: 600;
            text-transform: none;
            font-family: 'Poppins', sans-serif
        }

        h1 {
            line-height: 40px;
            font-size: 36px
        }

        h2 {
            margin: 70px 0 10px;
            font-size: 34px;
            line-height: 40px
        }

        h4 {
            line-height: 26px;
            font-size: 21px
        }

        .theme-cl {
            color: #f96825
        }

        ul:last-child {
            margin: 0
        }

        [data-overlay] {
            position: relative
        }

        [data-overlay]:before {
            position: absolute;
            content: '';
            background: #252525;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 1
        }

        [data-overlay] *:not(.container):not(.bg-img-holder) {
            z-index: 2
        }

        [data-overlay="6"]:before {
            opacity: 0.6
        }

        [data-overlay="8"]:before {
            opacity: 0.8
        }

        div[data-overlay] h1 {
            color: #fff
        }

        html body .b-r {
            border-right: 1px solid #e0ecf5 !important
        }

        html body .bg-white {
            background-color: #ffffff
        }

        .btn {
            border: 2px solid transparent
        }

        .btn {
            color: #ffffff;
            padding: 12px 25px;
            border-radius: 0.1rem
        }

        .btn-md {
            padding: 1em 1.5em;
            font-size: 1em
        }

        .sec-heading {
            margin-bottom: 10px
        }

        .sec-heading.center {
            text-align: center
        }

        .sec-heading h2,
        .sec-heading p {
            margin-bottom: 5px
        }

        .sec-heading.light h2,
        .sec-heading.light p {
            color: #ffffff
        }

        .sec-heading p {
            margin-bottom: 5px;
            font-style: italic;
            font-family: 'Lora', serif
        }

        .form-control {
            height: 56px;
            border-radius: 0;
            font-size: 17px;
            box-shadow: none;
            padding: .5rem .75rem;
            border: 1px solid #e0ecf5;
            background-clip: initial
        }

        select.form-control:not([size]):not([multiple]) {
            height: 56px
        }

        nav {
            min-height: 60px
        }

        nav.navbar-light {
            background: #ffffff;
            box-shadow: 0 5px 30px rgba(0, 22, 84, 0.1);
            -webkit-box-shadow: 0 5px 30px rgba(0, 22, 84, 0.1)
        }

        .image-cover {
            background-size: cover !important;
            background-position: center !important
        }

        .hero-banner {
            padding: 3em 0 3em;
            display: flex;
            flex-wrap: wrap;
            min-height: 400px;
            justify-content: center;
            align-items: center;
            min-height: 660px !important;
            height: auto !important
        }

        .btn.search-btn {
            background: #f96825;
            padding: 17px;
            border-radius: 5px;
            box-shadow: 0 5px 24px rgba(31, 37, 59, 0.15);
            color: #ffffff;
            width: 100%;
            font-size: 1.2rem
        }

        .hero-banner>* {
            position: relative;
            z-index: 1
        }

        .hero-banner h1 {
            font-weight: 800;
            line-height: 1.3
        }

        [data-overlay] {
            position: relative
        }

        [data-overlay]:before {
            position: absolute;
            content: '';
            background: #19365f;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 1
        }

        [data-overlay="6"]:before {
            opacity: 0.6
        }

        [data-overlay="8"]:before {
            opacity: 0.8
        }

        .hero-banner>* {
            position: relative;
            z-index: 22
        }

        .help-video {
            margin: 1rem 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap
        }

        .pulse {
            display: inline-block;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #f96825;
            box-shadow: 0 0 0 rgba(255, 255, 255, 0.6);
            animation: pulse 2s infinite;
            margin-right: 10px;
            position: relative
        }

        span.pulse:before {
            content: "\e6ad";
            font-family: themify;
            left: 10px;
            top: 7px;
            position: absolute
        }

        @-webkit-keyframes pulse {
            0% {
                -webkit-box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4)
            }

            70% {
                -webkit-box-shadow: 0 0 0 10px rgba(255, 255, 255, 0)
            }

            100% {
                -webkit-box-shadow: 0 0 0 0 rgba(255, 255, 255, 0)
            }
        }

        @keyframes pulse {
            0% {
                -moz-box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4);
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4)
            }

            70% {
                -moz-box-shadow: 0 0 0 10px rgba(255, 255, 255, 0);
                box-shadow: 0 0 0 10px rgba(255, 255, 255, 0)
            }

            100% {
                -moz-box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0)
            }
        }

        a.wt-video {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 15px 20px;
            color: #ffffff !important;
            font-weight: 600
        }

        .rt-log {
            transform: rotate(-90deg)
        }

        .full-search-2 {
            background: #ffffff;
            padding: 25px 25px 10px;
            border-radius: 6px
        }

        .full-search-2.hero-search-radius.box-style {
            background: #ffffff;
            padding: 10px 20px 5px;
            border-radius: 4px;
            box-shadow: 0px 0px 0px 7px rgba(255, 255, 255, .2);
            -webkit-box-shadow: 0px 0px 0px 7px rgba(255, 255, 255, .2);
            overflow: inherit
        }

        .italian-search.hero-search-radius.box-style .btn.search-btn {
            border-radius: 4px;
            height: 62px
        }

        .full-search-2 {
            background: #ffffff;
            padding: 18px 25px 10px;
            border-radius: 6px;
            overflow: hidden
        }

        .full-search-2.italian-search .form-group {
            margin-bottom: 5px
        }

        h1.big-header-capt {
            font-weight: 700;
            margin: 0 auto;
            margin-bottom: 0.4em;
            text-align: center;
            text-transform: uppercase
        }

        .italian-search .input-with-icon .form-control {
            border: none;
            border-radius: 3px;
            padding-left: 45px;
            height: 60px;
            background: #ffffff;
            box-shadow: none;
            -webkit-box-shadow: none;
            border: 1px solid #bec2cc
        }

        .small-padd {
            padding: 0 5px !important
        }

        .full-search-2.hero-search-radius {
            background: #ffffff;
            padding: 10px 20px 5px;
            border-radius: 50px
        }

        .italian-search.hero-search-radius .input-with-icon .form-control {
            border: none;
            border-radius: 3px;
            padding-left: 45px;
            height: 60px;
            background: #ffffff;
            box-shadow: none;
            -webkit-box-shadow: none;
            border: none
        }

        .italian-search.hero-search-radius .btn.search-btn {
            border-radius: 50px;
            height: 62px
        }

        .input-with-icon {
            position: relative;
            width: 100%
        }

        .input-with-icon .form-control {
            border: none;
            border-radius: 5px;
            padding-left: 45px;
            height: 60px;
            background: #ffffff;
            overflow: hidden;
            box-shadow: 0 0 6px 1px rgba(62, 28, 131, 0.1);
            -webkit-box-shadow: 0 0 6px 1px rgba(62, 28, 131, 0.1)
        }

        .input-with-icon i {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 15px;
            font-size: 18px;
            color: #a2a9bf;
            font-style: normal
        }

        .list-slide-box {
            padding: 10px 0
        }

        .modern-list {
            background: #ffffff;
            position: relative;
            display: block;
            border-radius: 14px;
            overflow: hidden;
            margin-bottom: 30px;
            box-shadow: 0 0 20px 0 rgba(62, 28, 131, 0.1);
            -webkit-box-shadow: 0 0 20px 0 rgba(62, 28, 131, 0.1);
            -moz-box-shadow: 0 0 20px 0 rgba(62, 28, 131, 0.1)
        }

        .list-slide-box .modern-list {
            margin-bottom: 0
        }

        .grid-category-thumb {
            display: table;
            width: 100%;
            min-height: 200px;
            padding: 10px;
            border-radius: 6px;
            overflow: hidden;
            position: relative
        }

        .grid-category-thumb img {
            border-radius: 10px
        }

        .modern-list-content {
            position: relative;
            padding: 5px 20px 15px;
            display: table;
            width: 100%
        }

        .lst-title {
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 3px
        }

        .list-rates i {
            color: #6e778a;
            font-size: 15px
        }

        .list-rates i.filled {
            color: #ff8000
        }

        .overlay-cate {
            position: relative;
            height: 100%;
            display: block
        }

        .overlay-cate:before {
            content: "";
            position: absolute;
            background: linear-gradient(to bottom, transparent 7%, #1a1d2b);
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            display: block;
            opacity: 1;
            border-radius: 6px
        }

        .modern-list .property_meta {
            display: block;
            margin: 0;
            position: absolute;
            left: 30px;
            bottom: 30px
        }

        .modern-list.ml-2 .lst-title a {
            color: #ffffff
        }

        .modern-list.ml-2 .list-rates {
            margin-bottom: 4px
        }

        .modern-list.ml-2 .list-rates i {
            color: #ffffff
        }

        .modern-list.ml-2 .list-rates i.filled {
            color: #ff8000
        }

        .property_meta {
            display: block;
            margin: 1.5em 0 0rem
        }

        span.veryfied-author:before {
            content: "\e64c";
            display: inline-block;
            font-family: 'themify';
            width: 20px;
            height: 20px;
            color: #ffffff;
            background: #29af6a;
            border-radius: 50%;
            margin-left: 7px;
            top: 2px;
            font-size: 10px;
            line-height: 20px;
            text-align: center
        }

        span.veryfied-author {
            position: relative
        }

        .listing-cat {
            flex: 1;
            float: left
        }

        a.cat-icon.cl-1 {
            color: red
        }

        .cat-icon i {
            width: 32px;
            height: 32px;
            display: table;
            background: red;
            border-radius: 50%;
            text-align: center;
            line-height: 32px;
            color: #ffffff;
            margin-right: 5px;
            float: left
        }

        a.cat-icon.cl-1 {
            color: #6d7a8a;
            font-weight: 600
        }

        label {
            color: #495e96;
            font-weight: 600
        }

        .modal-body {
            padding: 2.5em 2em
        }

        h4.modal-header-title {
            font-size: 4em;
            text-align: center;
            margin: 1rem 0 1em 0;
            font-weight: 800
        }

        .btn.pop-login {
            border-radius: 50px;
            padding: 20px 0;
            background: #f96825;
            border-color: #f96825;
            margin-top: 0.6rem
        }

        span.mod-close {
            width: 35px;
            height: 35px;
            position: absolute;
            top: 15px;
            right: 15px;
            background: white;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 13px;
            color: #f96825;
            z-index: 1;
            box-shadow: 0 5px 24px rgba(31, 37, 59, 0.15);
            -webkit-box-shadow: 0 5px 24px rgba(31, 37, 59, 0.15)
        }

        .form-control::-webkit-input-placeholder {
            color: #879ac3
        }

        .form-control:-ms-input-placeholder {
            color: #879ac3
        }

        @media (min-width:992px) {
            h1 {
                font-size: 4.142em;
                line-height: 1.31818182em
            }

            .sec-heading h2 {
                font-size: 44px;
                line-height: 1.2
            }

            .sec-heading p {
                font-size: 22px
            }

            .modal-dialog {
                max-width: 600px;
                margin: 30px auto
            }
        }

        @media (max-width:991px) {
            .hero-banner {
                min-height: 580px
            }

            .hero-banner h1 {
                font-size: 30px
            }
        }

        @media (max-width:767px) {
            .full-search-2.hero-search-radius {
                border-radius: 10px
            }

            .full-search-2.hero-search-radius .form-control {
                border: none !important
            }
        }

        #back2Top {
            width: 40px;
            line-height: 40px;
            overflow: hidden;
            z-index: 999;
            display: none;
            position: fixed;
            bottom: 10px;
            right: 20px;
            text-align: center;
            font-size: 15px;
            border-radius: 4px;
            text-decoration: none;
            background: #333c56;
            color: #ffffff
        }
    </style>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="preconnect" href="//api-maps.yandex.ru">
    <link rel="dns-prefetch" href="//api-maps.yandex.ru">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<?= Html::beginTag('body', [
    'class' => implode(' ', array_filter([
        'hold-transition',
        Yii::$app->keyStorage->get('frontend.theme-skin', 'purple-skin'),
    ])),
]) ?>
<?php $this->beginBody() ?>
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
        <div class="navbarText" id="navbarText">
            <ul class="attributes attributes-desk ad-two">
                <!-- <li class="log-icon lg-ic"><a href="#" data-toggle="modal" data-target="#login" class="rt-log"><i class="ti-import"></i></a></li> -->
            </ul>
        </div>
    </div>
</nav>

<div class="clearfix"></div>
<div class="container">
    <div id="noty-layer">
        <?= Wrapper::widget(); ?>
    </div>
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
</div>
<?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>