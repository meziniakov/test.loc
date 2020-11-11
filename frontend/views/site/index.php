<?php
/* @var $this yii\web\View */

use yii\bootstrap\Html;

$this->title = Yii::$app->name;
?>
			
			<!-- ============================ Hero Banner  Start================================== -->
			<div class="image-cover hero-banner" style="background:url(reveal/img/33.jpg) no-repeat;" data-overlay="6">
				<div class="container">
					
					<h1 class="big-header-capt">Лучшие места в городе</h1>
					<div class="full-search-2 italian-search hero-search-radius box-style">
						<div class="hero-search-content">
							
							<div class="row">
							
								<div class="col-lg-4 col-md-4 col-sm-12 small-padd">
									<div class="form-group">
										<div class="input-with-icon">
											<input type="text" class="form-control b-r" placeholder="Keywords...">
											<i class="theme-cl ti-search"></i>
										</div>
									</div>
								</div>
								
								<div class="col-lg-3 col-md-3 col-sm-12 small-padd">
									<div class="form-group">
										<div class="input-with-icon">
											<input type="text" class="form-control b-r" placeholder="Location...">
											<i class="theme-cl ti-target"></i>
										</div>
									</div>
								</div>
								
								<div class="col-lg-3 col-md-3 col-sm-6 small-padd">
									<div class="form-group">
										<div class="input-with-icon">
											<select id="list-category" class="form-control">
												<option value="">&nbsp;</option>
												<option value="1">Spa & Bars</option>
												<option value="2">Restaurants</option>
												<option value="3">Hotels</option>
												<option value="4">Educations</option>
												<option value="5">Business</option>
												<option value="6">Retail & Shops</option>
												<option value="7">Garage & Services</option>
											</select>
											<i class="theme-cl ti-briefcase"></i>
										</div>
									</div>
								</div>
								
								<div class="col-lg-2 col-md-2 col-sm-12 small-padd">
									<div class="form-group">
										<div class="form-group">
											<a href="#" class="btn search-btn">Search</a>
										</div>
									</div>
								</div>
								
							</div>
							
						</div>
						
					</div>
					
					<div class="help-video">
						<a href="#" class="wt-video"><span class="pulse"></span>Watch Video</a>
						<a href="#" class="sb-directory">Add Listing</a>
					</div>
				</div>
			</div>
			<!-- ============================ Hero Banner End ================================== -->
			
			<!-- ============================ Listings Start ================================== -->
			<section>
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="sec-heading center">
								<h2>Популярные места</h2>
								<p>Выберите подходящие места для Вас.</p>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="owl-carousel owl-theme" id="lists-slide">
							<?php foreach ($listing as $company): ?>
							<!-- Single List -->
							<div class="list-slide-box">
								<div class="modern-list ml-2">
									<div class="grid-category-thumb">
										<a href="search-listing.html" class="overlay-cate"><img src="/reveal/img/f389baedd25b0b8e84ba403877d6ebdf.jpg" class="img-responsive" alt="" /></a>
										<!-- <div class="listing-price-info"> 
											<span class="pricetag">$25 - $65</span>
										</div> -->
										<div class="property_meta"> 
											<div class="list-rates">
												<i class="ti-star filled"></i>	
												<i class="ti-star filled"></i>
												<i class="ti-star filled"></i>
												<i class="ti-star filled"></i>
												<i class="ti-star"></i>
												<!-- <a href="#" class="tl-review">(24 Reviews)</a> -->
											</div>
											<h4 class="lst-title"><?= Html::a($company->name, ['company/view', 'slug' => $company->slug])?><span class="veryfied-author"></span></h4> 
										</div>
									</div>
									<div class="modern-list-content">
										<div class="listing-cat">
											<a href="search-listing.html" class="cat-icon cl-1"><i class="ti-briefcase bg-a"></i><?= $company->type?></a>
											<!-- <span class="more-cat">+3</span> -->
										</div>
									</div>
								</div>	
							</div>
							<?php endforeach; ?>

						</div>
					</div>
				</div>
			</section>
			<!-- ============================ Listings End ================================== -->
			
			<!-- ============================ Categories Start ================================== -->
			<section class="image-cover" style="background:url(https://via.placeholder.com/1920x1000) no-repeat;" data-overlay="8">
				<div class="container">
				
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="sec-heading center light">
								<h2>Explore By Category</h2>
								<p>Find new & featured category for you.</p>
							</div>
						</div>
					</div>
					
					<div class="row">
						
						<!-- Single Category -->
						<div class="col-lg-3 col-md-6 col-sm-12">
							<div class="list-cats-boxr">
								<a href="grid-with-sidebar.html" class="category-box">
									<div class="category-desc">
										<div class="category-icon">
											<i class="lni-revenue theme-cl"></i>
											<i class="lni-revenue abs-icon"></i>
										</div>

										<div class="category-detail category-desc-text">
											<h4>Accounting</h4>
											<p>122 Listings</p>
										</div>
									</div>
								</a>	
							</div>
						</div>
						
						<!-- Single Category -->
						<div class="col-lg-3 col-md-6 col-sm-12">
							<div class="list-cats-boxr">
								<a href="grid-with-sidebar.html" class="category-box">
									<div class="category-desc">
										<div class="category-icon">
											<i class="lni-construction-hammer theme-cl"></i>
											<i class="abs-icon lni-construction-hammer"></i>
										</div>

										<div class="category-detail category-desc-text">
											<h4>Automotives</h4>
											<p>155 Listings</p>
										</div>
									</div>
								</a>
							</div>
						</div>
						
						<!-- Single Category -->
						<div class="col-lg-3 col-md-6 col-sm-12">
							<div class="list-cats-boxr">
								<a href="grid-with-sidebar.html" class="category-box">
									<div class="category-desc">
										<div class="category-icon">
											<i class="ti-briefcase theme-cl"></i>
											<i class="ti-briefcase abs-icon"></i>
										</div>

										<div class="category-detail category-desc-text">
											<h4>Business</h4>
											<p>300 Listings</p>
										</div>
									</div>
								</a>
							</div>
						</div>
						
						<!-- Single Category -->
						<div class="col-lg-3 col-md-6 col-sm-12">
							<div class="list-cats-boxr">
								<a href="grid-with-sidebar.html" class="category-box">
									<div class="category-desc">
										<div class="category-icon">
											<i class="ti-ruler-pencil theme-cl"></i>
											<i class="ti-ruler-pencil abs-icon"></i>
										</div>

										<div class="category-detail category-desc-text">
											<h4>Education</h4>
											<p>80 Listings</p>
										</div>
									</div>
								</a>
							</div>
						</div>
						
						<!-- Single Category -->
						<div class="col-lg-3 col-md-6 col-sm-12">
							<div class="list-cats-boxr">
								<a href="grid-with-sidebar.html" class="category-box">
									<div class="category-desc">
										<div class="category-icon">
											<i class="ti-heart-broken theme-cl"></i>
											<i class="ti-heart-broken abs-icon"></i>
										</div>

										<div class="category-detail category-desc-text">
											<h4>Healthcare</h4>
											<p>120 Listings</p>
										</div>
									</div>
								</a>	
							</div>
						</div>
						
						<!-- Single Category -->
						<div class="col-lg-3 col-md-6 col-sm-12">
							<div class="list-cats-boxr">
								<a href="grid-with-sidebar.html" class="category-box">
									<div class="category-desc">
										<div class="category-icon">
											<i class="lni-burger theme-cl"></i>
											<i class="lni-burger abs-icon"></i>
										</div>

										<div class="category-detail category-desc-text">
											<h4>Eat & Foods</h4>
											<p>78 Listings</p>
										</div>
									</div>
								</a>
							</div>
						</div>
						
						<!-- Single Category -->
						<div class="col-lg-3 col-md-6 col-sm-12">
							<div class="list-cats-boxr">
								<a href="grid-with-sidebar.html" class="category-box">
									<div class="category-desc">
										<div class="category-icon">
											<i class="ti-world theme-cl"></i>
											<i class="ti-world abs-icon"></i>
										</div>

										<div class="category-detail category-desc-text">
											<h4>Transportation</h4>
											<p>90 Listings</p>
										</div>
									</div>
								</a>
							</div>
						</div>
						
						<!-- Single Category -->
						<div class="col-lg-3 col-md-6 col-sm-12">
							<div class="list-cats-boxr">
								<a href="grid-with-sidebar.html" class="category-box">
									<div class="category-desc">
										<div class="category-icon">
											<i class="ti-desktop theme-cl"></i>
											<i class="ti-desktop abs-icon"></i>
										</div>

										<div class="category-detail category-desc-text">
											<h4> IT & Software</h4>
											<p>210 Listings</p>
										</div>
									</div>
								</a>
							</div>
						</div>
						
					</div>
					
				</div>
			</section>
			<!-- ============================ Categories End ================================== -->
			
			<!-- ============================ Destination Start ================================== -->
			<section>
				<div class="container">
					
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="sec-heading center">
								<h2>Find By Locations</h2>
								<p>Top &amp; perfect 200+ location listings.</p>
							</div>
						</div>
					</div>
					
					<div class="row">
					
						<div class="col-lg-8 col-md-8">
							<a href="list-layout-with-sidebar.html" class="img-wrap">
									<div class="img-wrap-content visible">
										<h4>Los Angeles</h4>
										<span>24 Listins</span>
									</div>
								<div class="img-wrap-background" style="background-image: url(https://via.placeholder.com/1200x850);"></div>
							</a>	
						</div>
						
						<div class="col-lg-4 col-md-4">
							<a href="list-layout-with-sidebar.html" class="img-wrap">
									<div class="img-wrap-content visible">
										<h4>San Francisco</h4>
										<span>104 Listins</span>
									</div>
								<div class="img-wrap-background" style="background-image: url(https://via.placeholder.com/1200x850);"></div>
							</a>
						</div>
						
					</div>
					
					<div class="row">
					
						<div class="col-lg-4 col-md-4">
							<a href="list-layout-with-sidebar.html" class="img-wrap">
									<div class="img-wrap-content visible">
										<h4>Philadelphia</h4>
										<span>74 Listins</span>
									</div>
								<div class="img-wrap-background" style="background-image: url(https://via.placeholder.com/1200x850);"></div>
							</a>	
						</div>
						
						<div class="col-lg-4 col-md-4">
							<a href="list-layout-with-sidebar.html" class="img-wrap">
									<div class="img-wrap-content visible">
										<h4>New York</h4>
										<span>312 Listins</span>
									</div>
								<div class="img-wrap-background" style="background-image: url(https://via.placeholder.com/1200x850);"></div>
							</a>
						</div>
						
						<div class="col-lg-4 col-md-4">
							<a href="list-layout-with-sidebar.html" class="img-wrap">
									<div class="img-wrap-content visible">
										<h4>San Diego</h4>
										<span>710 Listins</span>
									</div>
								<div class="img-wrap-background" style="background-image: url(https://via.placeholder.com/1200x850);"></div>
							</a>
						</div>
						
					</div>
					
				</div>
			</section>
			<!-- ============================ Destination End ================================== -->
			
			<!-- ============================ Call To Action Start ================================== -->
			<section class="theme-bg call-to-act">
				<div class="container">
					<div class="row align-items-center">
					
						<div class="col-lg-9 col-md-8">
							<div class="clt-caption">
								<h3>Ready To Start Work With Us?</h3>
								<p>Simple pricing plans. Unlimited web maintenance service</p>
							</div>
						</div>
						<div class="col-lg-3 col-md-4">
							<a href="#" class="btn btn-md btn-light clt-act">Join Us Today<i class="lni-shift-right ml-2"></i></a>	
						</div>
						
					</div>
				</div>
			</section>
			<!-- ============================ Call To Action End ================================== -->