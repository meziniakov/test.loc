<?php

// use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\models\NavItem;
use lo\modules\noty\Wrapper;
use frontend\widgets\LoginFormWidget;
use frontend\widgets\SignupFormWidget;
use frontend\widgets\Navy;
use frontend\widgets\NavyBar;
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
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="green-skin">
    <?php $this->beginBody() ?>
    <div id="preloader">
        <div class="preloader"><span></span><span></span></div>
    </div>
    <div id="main-wrapper">
        <?php
        $menuItems = [
            [
                'label' => Yii::t('frontend', 'Users'),
                'url' => ['/account/default/users'],
                'visible' => !Yii::$app->user->isGuest,
            ],
        ];
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => Yii::t('frontend', 'Login'), 'url' => ['/account/sign-in/login']];
        } else {
            $menuItems[] = [
                'label' => Yii::$app->user->identity->username,
                'url' => 'JavaScript:Void(0);',
                'options' => ['class' => 'dropdown'],
                'items' => [
                    ['label' => Yii::t('frontend', 'Settings'), 'url' => ['/account/default/settings']],
                    [
                        'label' => Yii::t('frontend', 'Backend'),
                        'url' => env('BACKEND_URL'),
                        'linkOptions' => ['target' => '_blank'],
                        'visible' => Yii::$app->user->can('administrator'),
                    ],
                    [
                        'label' => Yii::t('frontend', 'Logout'),
                        'url' => ['/account/sign-in/logout'],
                        'linkOptions' => ['data-method' => 'post'],
                    ],
                ],
            ];
        }
        ?>

        <div class="header header-light nav-left-side">
            <nav class="headnavbar">
                <div class="nav-header">
                    <a href="#" class="brand"><img src="/reveal/img/logo.png" alt="" /></a>
                    <button class="toggle-bar"><span class="ti-align-justify"></span></button>
                </div>
                <?php
                echo Menu::widget([
                    'options' => ['class' => 'menu core-nav-list'], //menu core-nav-list
                    'submenuTemplate' => "\n<ul class=\"dropdown-menu lg-wt animated bounceOut\">\n{items}\n</ul>\n",
                    'items' => ArrayHelper::merge(NavItem::getMenuItems(), $menuItems)
                ]);
                ?>
                <ul class="attributes attributes-desk ad-two">
                    <li class="log-icon lg-ic"><a href="#" data-toggle="modal" data-target="#login" class="rt-log"><i class="ti-import"></i></a></li>
                    <li class="submit-attri theme-log"><a href="add-listing.html">Submit Listing</a></li>
                </ul>
            </nav>
        </div>



        <div class="clearfix"></div>
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Wrapper::widget(); ?>
        </div>
        <?= $content ?>

        <footer class="dark-footer skin-dark-footer">
            <div>
                <div class="container">
                    <div class="row">

                        <div class="col-lg-4 col-md-6">
                            <div class="footer-widget">
                                <img src="/reveal/img/g-logo-light.png" class="img-fluid f-logo" alt="" />
                                <!-- <p>407-472 Rue Saint-Sulpice, Montreal<br>Quebec, H2Y 2V8</p> -->
                                <ul class="footer-bottom-social">
                                    <li><a href="#"><i class="ti-facebook"></i></a></li>
                                    <li><a href="#"><i class="ti-twitter"></i></a></li>
                                    <li><a href="#"><i class="ti-instagram"></i></a></li>
                                    <li><a href="#"><i class="ti-linkedin"></i></a></li>
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
                                <h4 class="widget-title">Пользователь</h4>
                                <ul class="footer-menu">
                                    <!-- <li class="log-icon lg-ic"><a href="#" data-toggle="modal" data-target="#signup1" class="rt-log">Регистрация1</a></li> -->
                                    <li class="log-icon lg-ic"><a href="#" data-toggle="modal" data-target="#signup" class="rt-log">Регистрация</a></li>
                                    <!-- <li class="log-icon lg-ic"><a href="#" data-toggle="modal" data-target="#login" class="rt-log">Вход</a></li> -->
                                    <!-- <li class="log-icon lg-ic"><a href="#" data-toggle="modal" data-target="#login" class="rt-log">Вход</a></li> -->
                                    <li class="log-icon lg-ic"><a href="#" data-toggle="modal" data-target="#login" class="rt-log">Войти</a></li>
                                    <li><?= Html::a('Статьи', ['article/index']) ?></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-4">
                            <div class="footer-widget">
                                <h4 class="widget-title">Поддержка</h4>
                                <ul class="footer-menu">
                                    <li><?= Html::a('Вопросы и ответы', ['site/faq']) ?></li>
                                    <li><?= Html::a('Контакты', ['site/contact']) ?></li>
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
                            <p class="mb-0">© 2019 SurfCity. All Rights Reserved</p>
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