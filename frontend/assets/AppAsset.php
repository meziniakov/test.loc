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
        'static/css/style.css',
        'reveal/css/plugins.css',
        'reveal/css/nav.css',
        'reveal/css/styles.css',
        'reveal/css/colors.css',
    ];
    public $js = [
        'reveal/js/jquery.min.js',
        'reveal/js/circleMagic.min.js',
        'reveal/js/popper.min.js',
        'reveal/js/jquery.magnific-popup.min.js',
        'reveal/js/bootstrap.min.js',
        'reveal/js/rangeslider.js',
        'reveal/js/select2.min.js',
        'reveal/js/aos.js',
        'reveal/js/owl.carousel.min.js',
        'reveal/js/slick.js',
        'reveal/js/slider-bg.js',
        'reveal/js/lightbox.js', 
        'reveal/js/imagesloaded.js',
        'reveal/js/isotope.min.js',
        'reveal/js/coreNavigation.js',
        'reveal/js/custom.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'common\assets\OpenSans',
        'common\assets\FontAwesome',
    ];
}
