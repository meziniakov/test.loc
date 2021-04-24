<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'reveal/css/nav-min.css',
        ['reveal/css/plugins.css', 'rel' => 'preload', 'as' => 'style', 'onload' => 'this.onload=null;this.rel="stylesheet"'],
        'reveal/css/bsp.css',
        'reveal/css/styles-min.css',
        'reveal/css/lineicon.css',
        ['https://fonts.gstatic.com', 'rel' => 'preconnect'],
        ['https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap', 'rel' => 'stylesheet'],
        // 'reveal/css/animation.css',
        // 'reveal/css/aos.css',
        // 'reveal/css/fontawesome.css',
        // 'reveal/css/iconfont.css',
        // 'reveal/css/yellow.css',
    ];
    public $js = [
        // 'reveal/js/jquery.min.js',
        'reveal/js/coreNavigation.js',
        'reveal/js/circleMagic.min.js',
        'reveal/js/popper.min.js',
        'reveal/js/jquery.magnific-popup.min.js', //фото во всплывающем окне
        // 'reveal/js/bootstrap.min.js',
        'reveal/js/rangeslider.js',
        'reveal/js/select2.min.js',
        'reveal/js/aos.js',
        'reveal/js/owl.carousel.min.js', //слайдер фото в карточке
        'reveal/js/slick.js',
        'reveal/js/slider-bg.js',
        'reveal/js/lightbox.js',
        // 'reveal/js/imagesloaded.js',
        // 'reveal/js/isotope.min.js',
        'reveal/js/custom.js',
    ];

    public $jsOptions = [
        // 'async' => 'async'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset', 
        // 'common\assets\OpenSans',
        // 'common\assets\FontAwesome',
    ];
}
