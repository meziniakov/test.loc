<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\UserProfile;
use bs\Flatpickr\FlatpickrWidget;
use vova07\fileapi\Widget as FileApi;

/* @var $this yii\web\View */
/* @var $model common\models\UserProfile */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('frontend', 'Settings');
// $this->params['breadcrumbs'][] = $this->title;
?>

			<!-- ============================ Page Title Start================================== -->
			<div class="image-cover author-profile" style="background:url(/reveal/img/11.jpg) no-repeat;" data-overlay="6">
				<div class="container">
					<div class="row">
					
					</div>
				</div>
			</div>
			<!-- ============================ Page Title End ================================== -->
			
			<!-- ============================ Our Story Start ================================== -->
			<section class="pt-0 gray">
			
				<div class="container detail-wrap-up">
				
					<!-- row Start -->
					<div class="row">

						<div class="col-lg-4 col-md-4 col-sm-12">
							<div class="autor-bio-wrap">
								
								<!-- author thumb -->
								<div class="author-thumb">
									<div class="author-thumb-pic">
                                    <?php if ($profile->avatar_path) : ?>
                                        <img src="<?= Yii::getAlias('@storageUrl/avatars/' . $profile->avatar_path) ?>" class="img-fluid circle" alt>
                                    <?php else: ?>
                                        <img src="<?= Yii::$app->homeUrl . '/static/img/default.png' ?>" class="img-fluid circle" alt>
                                    <?php endif ?>
										<!-- <img src="https://via.placeholder.com/400x400" class="img-fluid circle" alt=""> -->
									</div>
									<div class="author-thumb-caption">
										<h4><?= $model->firstname?> <?= $model->lastname?></h4>
										<span><?= $model->firstname?></span>
									</div>
								</div>
								
								<!-- author detail -->
								<div class="author-full-detail">
								
									<div class="author-bio-single-list">
										<i class="lni-map-marker"></i>Location
										<h6>California, USA</h6>
									</div>
									
									<div class="author-bio-single-list">
										<i class="ti-email"></i>Email
										<h6>24support@reveal.com</h6>
									</div>
									
									<div class="author-bio-single-list">
										<i class="lni-phone-handset"></i>Call
										<h6>+91 123 546 5847</h6>
									</div>
									
								</div>
								
								<!-- Author List Count -->
								<div class="author-list-detail">
								
									<ul class="author-list-counter">
										<li>Saved<span>55</span></li>
										<li>Freinds<span>772</span></li>
										<li>Posts<span>136</span></li>
									</ul>
									
								</div>
								
							</div>
						</div>

						<div class="col-lg-8 col-md-8 col-sm-12">
							
							<!-- Tab Navigation -->
							<div class="author-tab-header">
								<ul class="nav nav-tabs" id="author-tab" role="tablist">
								  <li class="nav-item">
									<a class="nav-link active" id="author-about-tab" data-toggle="pill" href="#author-about" role="tab" aria-controls="author-about" aria-selected="true">Информация</a>
								  </li>
								  <li class="nav-item">
									<a class="nav-link" id="author-listing-tab" data-toggle="pill" href="#author-listing" role="tab" aria-controls="author-listing" aria-selected="false">Listings<span class="author-count">12</span></a>
								  </li>
								  <li class="nav-item">
									<a class="nav-link" id="author-events-tab" data-toggle="pill" href="#author-events" role="tab" aria-controls="author-events" aria-selected="false">Events<span class="author-count">8</span></a>
								  </li>
								  <li class="nav-item">
									<a class="nav-link" id="author-hotel-tab" data-toggle="pill" href="#author-hotel" role="tab" aria-controls="author-hotel" aria-selected="false">Hotel<span class="author-count">0</span></a>
								  </li>
								  <li class="nav-item">
									<a class="nav-link" id="author-passwd-tab" data-toggle="pill" href="#author-passwd" role="tab" aria-controls="author-passwd" aria-selected="false">Сменить пароль<span class="author-count">0</span></a>
								  </li>
								</ul>
							</div>
							
							<!-- All Tab Content -->
							<div class="tab-content" id="author-tabContent">
	
								<!-- About Tab Content -->
								<div class="tab-pane fade show active" id="author-about" role="tabpanel" aria-labelledby="author-about-tab">
									
									<!-- About Content -->
									<div class="block-wrap">
																				
										<div class="block-body">

                                        <?php $form = ActiveForm::begin(); ?>

                                        <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>

                                        <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>

                                        <?= $form->field($model, 'birthday')->widget(FlatpickrWidget::class, [
                                            'locale' => strtolower(substr(Yii::$app->language, 0, 2)),
                                            'groupBtnShow' => true,
                                            'options' => [
                                                'class' => 'form-control',
                                            ],
                                            'clientOptions' => [
                                                'allowInput' => true,
                                                'defaultDate' => $model->birthday ? date(DATE_ATOM, $model->birthday) : null,
                                            ],
                                        ]) ?>

                                        <?= $form->field($model, 'avatar_path')->widget(FileApi::class, [
                                            'settings' => [
                                                'url' => ['/site/fileapi-upload'],
                                            ],
                                            'crop' => true,
                                            'cropResizeWidth' => 100,
                                            'cropResizeHeight' => 100,
                                        ]) ?>

                                        <?= $form->field($model, 'gender')->dropDownlist([
                                            UserProfile::GENDER_MALE => Yii::t('frontend', 'Male'),
                                            UserProfile::GENDER_FEMALE => Yii::t('frontend', 'Female'),
                                        ], ['prompt' => '']) ?>

                                        <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>

                                        <?= $form->field($model, 'other')->textarea(['rows' => 6]) ?>

                                        <div class="form-group">
                                            <?= Html::submitButton(Yii::t('frontend', 'Update'), ['class' => 'btn btn-primary']) ?>
                                        </div>

                                        <?php ActiveForm::end() ?>										
                                        </div>
										
									</div>
									
								</div>
							  
								<!-- listing Tab Content -->
								<div class="tab-pane fade" id="author-listing" role="tabpanel" aria-labelledby="author-listing-tab">
									<!-- Featured Listings -->
									<div class="block-wrap">
										
										<div class="block-header">
											<h4 class="block-title">All Listings</h4>
										</div>
										
										<div class="block-body">
											
											<!--- All List -->
											<div class="row">
												
												<!-- Single Listing -->
												<div class="col-lg-6 col-md-12 col-sm-12">
													<div class="list-slide-box">
														<div class="modern-list ml-2">
															<div class="grid-category-thumb">
																<a href="search-listing.html" class="overlay-cate"><img src="https://via.placeholder.com/1200x850" class="img-responsive" alt="" /></a>
																<div class="listing-price-info"> 
																	<span class="pricetag">$25 - $65</span>
																</div>
																<div class="property_meta"> 
																	<div class="list-rates">
																		<i class="ti-star filled"></i>	
																		<i class="ti-star filled"></i>
																		<i class="ti-star filled"></i>
																		<i class="ti-star filled"></i>
																		<i class="ti-star"></i>
																		<a href="#" class="tl-review">(24 Reviews)</a>
																	</div>
																	<h4 class="lst-title"><a href="listing-detail.html">Castle Palace</a><span class="veryfied-author"></span></h4> 
																</div>
															</div>
															<div class="modern-list-content">
																<div class="listing-cat">
																	<a href="search-listing.html" class="cat-icon cl-1"><i class="ti-briefcase bg-a"></i>Services</a>
																	<span class="more-cat">+3</span>
																</div>
																<div class="author-avater">
																	<img src="https://via.placeholder.com/400x400" class="author-avater-img" alt="">
																</div>
															</div>
														</div>	
													</div>
												</div>
												
												
												<div class="col-md-12 col-sm-12 mt-3">
													<div class="text-center">
														
														<div class="spinner-grow text-danger" role="status">
														  <span class="sr-only">Loading...</span>
														</div>
														<div class="spinner-grow text-warning" role="status">
														  <span class="sr-only">Loading...</span>
														</div>
														<div class="spinner-grow text-success" role="status">
														  <span class="sr-only">Loading...</span>
														</div>
														
													</div>
												</div>
												
											</div>
											
										</div>
										
									</div>
								</div>
								
								<!-- events Tab Content -->
								<div class="tab-pane fade" id="author-events" role="tabpanel" aria-labelledby="author-events-tab">
									<!-- Featured Listings -->
									<div class="block-wrap">
										
										<div class="block-header">
											<h4 class="block-title">All Events</h4>
										</div>
										
										<div class="block-body">
											
											<div class="alert alert-success" role="alert">
											  There are no any events.
											</div>
											
										</div>
										
									</div>
								</div>
								
								<!-- hotel Tab Content -->
								<div class="tab-pane fade" id="author-hotel" role="tabpanel" aria-labelledby="author-hotel-tab">
									<!-- Featured Listings -->
									<div class="block-wrap">
										
										<div class="block-header">
											<h4 class="block-title">All Hotels</h4>
										</div>
										
										<div class="block-body">
											<div class="row">
												
												<!-- Single Hotel -->
												<div class="col-lg-6 col-md-12 col-sm-12">
													<article class="hotel-box style-1">

														<div class="hotel-box-image">
															<figure>
																<a href="booking.html">
																	<img src="https://via.placeholder.com/1280x850" class="img-responsive listing-box-img" alt="" />
																	<div class="list-overlay"></div>
																	<div class="read_more"><span>Read more</span></div>
																</a>
																<div class="discount-flick">-12%</div>
																<h4 class="hotel-place">
																	<a href="#">New York, Us</a>
																</h4>
																
															</figure>
															
														</div>
														
														<div class="entry-meta">
															<div class="meta-item meta-rating">
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star"></i>
																<i class="fa fa-star-half"></i>
															</div>
															<div class="meta-item meta-comment fl-right">
																<span class="real-price padd-l-10">From $710/Person</span>
															</div>
														</div>
														
														<div class="hotel-detail-box">
															<div class="hotel-ellipsis">
																<h4 class="hotel-name">
																	<a href="booking.html">Hotel Green Vallery</a>
																</h4>
																<p>Proin mi nisi, ultrices eget dictum a, volutpat at risus. Aliquam elementum.</p>
															</div>
														</div>

														<div class="hotel-inner inner-box">
															<div class="box-inner-ellipsis">
																<div class="hotel-review entry-location">
																	<span class="review-status bg-success"><i class="ti-check"></i></span>
																	<h6><span class="text-success font-bold">Good</span>1362 Review</h6>
																</div>
																<div class="view-box">
																	<div class="fl-right">
																		<span><i class="ti-eye padd-r-5"></i>782</span>
																	</div>
																</div>
															</div>
														</div>
														
													</article>
												</div>												
												
											</div>
										</div>
										
									</div>
								</div>
								
								<!-- restaurants Tab Content -->
								<div class="tab-pane fade" id="author-passwd" role="tabpanel" aria-labelledby="author-passwd-tab">
									<!-- Featured Listings -->
									<div class="block-wrap">
										
										<div class="block-header">
                                            <h4 class="block-title">Сменить пароль</h4>
                                            <?= Html::a(Yii::t('frontend', 'Change password'), ['password'], ['class' => 'btn btn-success']) ?>
										</div>
																				
									</div>
								</div>
								
							</div>
							
						</div>
						
					</div>
					<!-- /row -->					
					
				</div>
						
			</section>