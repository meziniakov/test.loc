<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\models\NavItem;
use lo\modules\noty\Wrapper;

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
<body>
<?php $this->beginBody() ?>
<div class="green-skin">

        <!-- ============================================================== -->
        <!-- Preloader - style you can find in spinners.css -->
        <!-- ============================================================== -->
        <div id="preloader"><div class="preloader"><span></span><span></span></div></div>
		
        <!-- ============================================================== -->
        <!-- Main wrapper - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <div id="main-wrapper">
            
    <?php //NavBar::begin(
        // [
    //     // 'brandLabel' => Yii::$app->name,
    //     'brandUrl' => Yii::$app->homeUrl,
        // 'containerOptions' => ['class' => ['collapse' => '', 'widget' => ''], 'id' => ''],

    //     'options' => [
    //         'class' => 'headnavbar core-nav',
    //     ],
    // ]);
    $menuItems = [
        ['label' => Yii::t('frontend', 'Главная'), 'url' => ['/']],
        ['label' => Yii::t('frontend', 'Компании'), 'url' => ['/company/index']],
        ['label' => Yii::t('frontend', 'Articles'), 'url' => ['/article/index']],
        [
            'label' => Yii::t('frontend', 'Users'),
            'url' => ['/account/default/users'],
            'visible' => !Yii::$app->user->isGuest,
        ],
        ['label' => Yii::t('frontend', 'Contact'), 'url' => ['/site/contact']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => Yii::t('frontend', 'Login'), 'url' => ['/account/sign-in/login']];
    } else {
        $menuItems[] = [
            'label' => Yii::$app->user->identity->username,
            'url' => '#',
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
    <div class="header light-header nav-left-side">
    <nav class="headnavbar">
        <div class="nav-header">
            <a href="#" class="brand"><img src="/reveal/img/logo.png" alt="" /></a>
            <button class="toggle-bar"><span class="ti-align-justify"></span></button>	
        </div>
        <?php 
        // echo Nav::widget([
        // 'options' => ['class' => ['class' => 'menu core-nav-list']],
        // 'items' => ArrayHelper::merge(NavItem::getMenuItems(), $menuItems)]);
    ?>					
        <ul class="menu">
            <li>
                <?= Html::a(Yii::t('frontend', 'Главная'), '/');?>
            </li>
            <li>
                <?= Html::a(Yii::t('frontend', 'Компании'), '/company');?>
            </li>
            <li>
                <?= Html::a(Yii::t('frontend', 'Articles'), '/article/index');?>
            </li>

            <!-- <li class="dropdown">
                <a href="JavaScript:Void(0);" class="active">Home</a>
                <ul class="dropdown-menu">
                    <li class="dropdown">
                        <a href="JavaScript:Void(0);">Standard Style</a>
                        <ul class="dropdown-menu">
                            <li><a href="index.html">Home Style 1</a></li>                                    
                            <li><a href="home-3.html">Home Style 2</a></li>                                    
                            <li><a href="home-4.html">Home Style 3</a></li> 
                            <li><a href="home-5.html">Home Style 4</a></li> 
                            <li><a href="home-6.html">Home Style 5</a></li> 
                            <li><a href="home-7.html" class="active">Home Style 6</a></li> 
                            <li><a href="home-8.html">Home Style 7</a></li>  										
                        </ul>                                 
                    </li>
                    <li class="dropdown">
                        <a href="JavaScript:Void(0);">Air BNB Style</a>
                        <ul class="dropdown-menu">
                            <li><a href="home-2.html">Home Style 1</a></li>
                            <li><a href="home-9.html">Home Style 2</a></li>
                            <li><a href="home-10.html">Home Style 3</a></li>										
                        </ul>                                
                    </li>
                    <li class="dropdown">
                        <a href="JavaScript:Void(0);">Map Style</a>
                        <ul class="dropdown-menu">
                            <li><a href="map.html">Map Style</a></li>                                    
                            <li><a href="half-map-with-grid2-layout.html">Half map Style</a></li>                                       
                        </ul>                                 
                    </li>
                </ul>
            </li> -->
            
            <li class="dropdown">
                <a href="JavaScript:Void(0);">Explore</a>
                <ul class="dropdown-menu lg-wt">
                    <li>
                        <a href="hotels.html">
                            <div class="mg-menu-items">
                                <i class="lni-apartment"></i>
                                <h5>Find Hotels<span>Search Your Hotels</span></h5>
                            </div>
                        </a>
                    </li>
                    
                    <li>
                        <a href="adventures.html">
                            <div class="mg-menu-items">
                                <i class="lni-coffee-cup"></i>
                                <h5>Find Adventures<span>Discover Adventures</span></h5>
                            </div>
                        </a>
                    </li>
                    
                    <li>
                        <a href="restaurants.html">
                            <div class="mg-menu-items">
                                <i class="lni-restaurant"></i>
                                <h5>Find Restaurants<span>Nearest Restaurants</span></h5>
                            </div>
                        </a>
                    </li>
                    
                    <li>
                        <a href="booking.html">
                            <div class="mg-menu-items">
                                <i class="lni-burger"></i>
                                <h5>Booking Page<span>See Your Booking Page</span></h5>
                            </div>
                        </a>
                    </li>
                    
                    <li>
                        <a href="dashboard.html">
                            <div class="mg-menu-items">
                                <i class="lni-dashboard"></i>
                                <h5>User Dashboard<span>Checkout Your Profile Page</span></h5>
                            </div>
                        </a>
                    </li>
                    
                    <li>
                        <a href="add-listing.html">
                            <div class="mg-menu-items">
                                <i class="lni-plus"></i>
                                <h5>Submit Listing<span>Submit Your Listings</span></h5>
                            </div>
                        </a>
                    </li>
                    
                </ul>
            </li>
            
            <li class="dropdown">
                <a href="JavaScript:Void(0);">Listings</a>
                <ul class="dropdown-menu">
                    <li class="dropdown">
                        <a href="JavaScript:Void(0);">List Layouts</a>
                        <ul class="dropdown-menu">
                            <li><a href="list-layout-with-sidebar.html">With Sadebar</a></li>
                            <li><a href="list-layout-full-width.html">Full Width</a></li>										
                            <li><a href="list-layout-with-map.html">With Map</a></li>                                    
                                                                 
                        </ul>                                 
                    </li>
                    <li class="dropdown">
                        <a href="JavaScript:Void(0);">Grid Layouts</a>
                        <ul class="dropdown-menu">
                            <li><a href="grid-with-sidebar.html">With Sidebar</a></li>                                    
                            <li><a href="grid-full-width.html">With Full Width</a></li>                                    
                            <li><a href="grid-with-map.html">With Map</a></li>                                    									
                        </ul>                                 
                    </li>
                    <li class="dropdown">
                        <a href="JavaScript:Void(0);">Half Map Screen</a>
                        <ul class="dropdown-menu">
                            <li><a href="half-map-with-list-layout.html">With List Layout</a></li>                                    
                            <li><a href="half-map-with-grid-layout.html">With Grid Layout</a></li>                                    
                            <li><a href="half-map-with-grid2-layout.html">With Grid Layout 2</a></li>                                     
                        </ul>                                 
                    </li>
                    <li class="dropdown">
                        <a href="JavaScript:Void(0);">Single Listing</a>
                        <ul class="dropdown-menu">
                            <li><a href="single-property-1.html">Single Listing 1</a></li>                                    
                            <li><a href="single-property-2.html">Single Listing 2</a></li>                                    
                            <li><a href="single-property-3.html">Single Listing 3</a></li>                                       
                        </ul>                                 
                    </li>
                    
                </ul>
            </li>
            
            <li class="megamenu" data-width="500">
                <a href="#">Pages</a>
                <div class="megamenu-content">
                    <div class="mg-menu">
                        <ul>
                            <li>
                                <a href="blog.html">
                                    <div class="mg-menu-items">
                                        <i class="ti-layout-grid2"></i>
                                        <h5>Blog Page<span>Checkout Our Articles</span></h5>
                                    </div>
                                </a>
                            </li>
                            
                            <li>
                                <a href="blog-detail.html">
                                    <div class="mg-menu-items">
                                        <i class="ti-layout"></i>
                                        <h5>Blog Detail<span>Detail Blog Page Design</span></h5>
                                    </div>
                                </a>
                            </li>
                            
                            <li>
                                <a href="pricing.html">
                                    <div class="mg-menu-items">
                                        <i class="ti-credit-card"></i>
                                        <h5>Pricing Page<span>Our Latest Offers & Package</span></h5>
                                    </div>
                                </a>
                            </li>
                            
                            <li>
                                <a href="contact.html">
                                    <div class="mg-menu-items">
                                        <i class="ti-location-pin"></i>
                                        <h5>Contact Us<span>Need Help? Get In Touch</span></h5>
                                    </div>
                                </a>
                            </li>
                            
                            <li>
                                <a href="component.html">
                                    <div class="mg-menu-items">
                                        <i class="ti-ruler-pencil"></i>
                                        <h5>Component<span>List of All Components</span></h5>
                                    </div>
                                </a>
                            </li>
                            
                            <li>
                                <a href="404.html">
                                    <div class="mg-menu-items">
                                        <i class="ti-face-sad"></i>
                                        <h5>Error Page<span>Error Page Design</span></h5>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
            
        </ul>
            
        <ul class="attributes attributes-desk ad-two">
            <li class="log-icon lg-ic"><a href="#" data-toggle="modal" data-target="#login" class="rt-log"><i class="ti-import"></i></a></li>
            <li class="submit-attri theme-log"><a href="add-listing.html">Submit Listing</a></li>
        </ul> 
        
    </nav>
</div>
<!-- End Navigation -->

    <?php //NavBar::end() ?>
			<div class="clearfix"></div>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Wrapper::widget(); ?>
        <?php if( Yii::$app->session->hasFlash('success') ): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo Yii::$app->session->getFlash('success'); ?>
            </div>
        <?php endif;?>
        </div>
    <?= $content ?>

</div>

<!-- ============================ Footer Start ================================== -->
<footer class="dark-footer skin-dark-footer">
    <div>
        <div class="container">
            <div class="row">
                
                <div class="col-lg-4 col-md-6">
                    <div class="footer-widget">
                        <img src="/reveal/img/g-logo-light.png" class="img-fluid f-logo" alt="" />
                        <p>407-472 Rue Saint-Sulpice, Montreal<br>Quebec, H2Y 2V8</p>
                        <ul class="footer-bottom-social">
                            <li><a href="#"><i class="ti-facebook"></i></a></li>
                            <li><a href="#"><i class="ti-twitter"></i></a></li>
                            <li><a href="#"><i class="ti-instagram"></i></a></li>
                            <li><a href="#"><i class="ti-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>		
                <div class="col-lg-2 col-md-4">
                    <div class="footer-widget">
                        <h4 class="widget-title">Useful links</h4>
                        <ul class="footer-menu">
                            <li><a href="about-us.html">About Us</a></li>
                            <li><a href="faq.html">FAQs Page</a></li>
                            <li><a href="checkout.html">Checkout</a></li>
                            <li><a href="login.html">Login</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-4">
                    <div class="footer-widget">
                        <h4 class="widget-title">Developers</h4>
                        <ul class="footer-menu">
                            <li><a href="booking.html">Booking</a></li>
                            <li><a href="stays.html">Stays</a></li>
                            <li><a href="adventures.html">Adventures</a></li>
                            <li><a href="author-detail.html">Author Detail</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-4">
                    <div class="footer-widget">
                        <h4 class="widget-title">Useful links</h4>
                        <ul class="footer-menu">
                            <li><a href="about-us.html">About Us</a></li>
                            <li><a href="faq.html">Jobs</a></li>
                            <li><a href="checkout.html">Events</a></li>
                            <li><a href="about-us.html">Press</a></li>
                        </ul>
                    </div>
                </div>
                        
                <div class="col-lg-2 col-md-4">
                    <div class="footer-widget">
                        <h4 class="widget-title">Useful links</h4>
                        <ul class="footer-menu">
                            <li><a href="about-us.html">Support</a></li>
                            <li><a href="contact.html">Contact Us</a></li>
                            <li><a href="checkout.html">Privacy & Terms</a></li>
                            <li class="log-icon lg-ic"><a href="#" data-toggle="modal" data-target="#signup" class="rt-log">Регистрация</a></li>
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
                    <p class="mb-0">© 2019 Reveal. Designd By <a href="https://themezhub.com">Themez Hub</a> All Rights Reserved</p>
                </div>
                
            </div>
        </div>
    </div>
</footer>
			<!-- Log In Modal -->
			<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="registermodal">
				<div class="modal-dialog modal-dialog-centered login-pop-form" role="document">
					<div class="modal-content" id="registermodal">
						<span class="mod-close" data-dismiss="modal"><i class="ti-close"></i></span>
						<div class="modal-body">
							<h4 class="modal-header-title">Log <span class="theme-cl">In</span></h4>
							<div class="login-form">
								<form>
								
									<div class="form-group">
										<label>User Name</label>
										<div class="input-with-icon">
											<input type="text" class="form-control" placeholder="Username">
											<i class="ti-user"></i>
										</div>
									</div>
									
									<div class="form-group">
										<label>Password</label>
										<div class="input-with-icon">
											<input type="password" class="form-control" placeholder="*******">
											<i class="ti-unlock"></i>
										</div>
									</div>
									
									<div class="form-group">
										<button type="submit" class="btn btn-md full-width pop-login">Login</button>
									</div>
								
								</form>
							</div>
							<div class="modal-divider"><span>Or login via</span></div>
							<div class="social-login mb-3">
								<ul>
									<li><a href="#" class="btn connect-fb"><i class="ti-facebook"></i>Facebook</a></li>
									<li><a href="#" class="btn connect-twitter"><i class="ti-twitter"></i>Twitter</a></li>
								</ul>
							</div>
							<div class="text-center">
								<p class="mt-5"><a href="#" class="link">Forgot password?</a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End Modal -->
			
			<!-- Sign Up Modal -->
			<div class="modal fade signup" id="signup" tabindex="-1" role="dialog" aria-labelledby="sign-up">
				<div class="modal-dialog modal-dialog-centered login-pop-form" role="document">
					<div class="modal-content" id="sign-up">
						<span class="mod-close" data-dismiss="modal"><i class="ti-close"></i></span>
						<div class="modal-body">
							<h4 class="modal-header-title">Sign <span class="theme-cl">Up</span></h4>
							<div class="login-form">
								<form>
									
									<div class="row">
										
										<div class="col-lg-6 col-md-6">
											<div class="form-group">
												<div class="input-with-icon">
													<input type="text" class="form-control" placeholder="First name">
													<i class="ti-user"></i>
												</div>
											</div>
										</div>
										
										<div class="col-lg-6 col-md-6">
											<div class="form-group">
												<div class="input-with-icon">
													<input type="text" class="form-control" placeholder="Last name">
													<i class="ti-user"></i>
												</div>
											</div>
										</div>
										
										<div class="col-lg-6 col-md-6">
											<div class="form-group">
												<div class="input-with-icon">
													<input type="text" class="form-control" placeholder="Username">
													<i class="ti-user"></i>
												</div>
											</div>
										</div>
										
										<div class="col-lg-6 col-md-6">
											<div class="form-group">
												<div class="input-with-icon">
													<input type="email" class="form-control" placeholder="Email">
													<i class="ti-email"></i>
												</div>
											</div>
										</div>
	
										<div class="col-lg-6 col-md-6">
											<div class="form-group">
												<div class="input-with-icon">
													<input type="password" class="form-control" placeholder="Password">
													<i class="ti-unlock"></i>
												</div>
											</div>
										</div>
										
										<div class="col-lg-6 col-md-6">
											<div class="form-group">
												<div class="input-with-icon">
													<input type="password" class="form-control" placeholder="Confirm Password">
													<i class="ti-unlock"></i>
												</div>
											</div>
										</div>
										
									</div>
									
									<div class="form-group">
										<button type="submit" class="btn btn-md full-width pop-login">Sign Up</button>
									</div>
								
								</form>
							</div>
							<div class="modal-divider"><span>Or login via</span></div>
							<div class="social-login mb-3">
								<ul>
									<li><a href="#" class="btn connect-fb"><i class="ti-facebook"></i>Facebook</a></li>
									<li><a href="#" class="btn connect-twitter"><i class="ti-twitter"></i>Twitter</a></li>
								</ul>
							</div>
							<div class="text-center">
								<p class="mt-5"><i class="ti-user mr-1"></i>Already Have An Account? <a href="#" class="link">Go For LogIn</a></p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- End Modal -->
			
			<a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>
			
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
