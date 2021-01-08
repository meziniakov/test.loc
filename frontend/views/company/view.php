<?php
$this->title = $company->name;
$this->registerJsFile(
	"/reveal/js/ymap.js",
	$options = ['depends' => ['frontend\assets\AppAsset']]
);
?>
<div class="featured-slick">
	<div class="featured-slick-slide">
		<?php $images = $company->getImages(); ?>
		<?php foreach ($images as $img) : ?>
			<div><a href="<?= $img->getUrl('560x359'); ?>" class="mfp-gallery"><img src="<?= $img->getUrl('560x359'); ?>" class="img-fluid mx-auto" title="<?= $img->title ?>" alt="<?= $img->alt ?>" /></a></div>
		<?php endforeach; ?>
	</div>
</div>

<section class="spd-wrap">
	<div class="container">
		<div class="row">

			<div class="col-lg-12 col-md-12">

				<div class="slide-property-detail">

					<div class="slide-property-first">
						<div class="listname-into">
							<h2><?= $company->name ?> <span class="prt-type rent"><?= $company->type ?></span></h2>
							<span><?= $company->address ? '<i class="lni-map-marker"></i>' . $company->address : '' ?></span>
						</div>
					</div>

					<div class="slide-property-sec">
						<div class="pr-all-info">

							<div class="pr-single-info">
								<div class="share-opt-wrap">
									<button type="button" class="btn-share" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-original-title="Share this">
										<i class="lni-share"></i>
									</button>
									<div class="dropdown-menu animated flipInX">
										<a href="#" class="cl-facebook"><i class="lni-facebook"></i></a>
										<a href="#" class="cl-twitter"><i class="lni-twitter"></i></a>
										<a href="#" class="cl-gplus"><i class="lni-google-plus"></i></a>
										<a href="#" class="cl-instagram"><i class="lni-instagram"></i></a>
									</div>
								</div>

							</div>

							<div class="pr-single-info">
								<a href="JavaScript:Void(0);" data-toggle="tooltip" data-original-title="Get Print"><i class="ti-printer"></i></a>
							</div>

							<div class="pr-single-info">
								<a href="JavaScript:Void(0);" class="compare-button" data-toggle="tooltip" data-original-title="Compare"><i class="ti-control-shuffle"></i></a>
							</div>

							<div class="pr-single-info">
								<a href="JavaScript:Void(0);" class="like-bitt add-to-favorite" data-toggle="tooltip" data-original-title="Add To Favorites"><i class="lni-heart-filled"></i></a>
							</div>

						</div>
					</div>

				</div>

			</div>
		</div>
	</div>
</section>
<!-- ============================ Hero Banner End ================================== -->

<!-- ============================ Property Detail Start ================================== -->
<section class="gray">
	<div class="container">
		<div class="row">

			<!-- property main detail -->
			<div class="col-lg-8 col-md-12 col-sm-12">

				<!-- Single Block Wrap -->
				<div class="block-wrap">

					<div class="block-header">
						<h4 class="block-title">О компании "<?= $company->name ?>"</h4>
					</div>

					<div class="block-body">
						<p><?= $company->description ?></p>
					</div>

				</div>

				<!-- Удобства -->
				<!-- <div class="block-wrap">
								
								<div class="block-header">
									<h4 class="block-title">Удобства</h4>
								</div>
								
								<div class="block-body">
									<ul class="avl-features third">
										<li>Air Conditioning</li>
										<li>Swimming Pool</li>
										<li>Central Heating</li>
										<li>Laundry Room</li>
										<li>Gym</li>
										<li>Alarm</li>
										<li>Window Covering</li>
										<li>Internet</li>
										<li>Pets Allow</li>
										<li>Free WiFi</li>
										<li>Car Parking</li>
										<li>Spa & Massage</li>
									</ul>
								</div>
								
							</div> -->
				<!-- Карта -->
				<div class="block-wrap">

					<div class="block-header">
						<h4 class="block-title">Location</h4>
					</div>

					<div class="block-body">
						<div class="map-container">
							<div id="singleMap" data-latitude="<?= $company->lat ?>" data-longitude="<?= $company->lng ?>" data-mapTitle="Our Location"></div>
						</div>

					</div>
				</div>

				<!-- Review Block Wrap -->
				<div class="rating-overview">
					<div class="rating-overview-box">
						<span class="rating-overview-box-total">4.2</span>
						<span class="rating-overview-box-percent">out of 5.0</span>
						<div class="star-rating" data-rating="5"><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i><i class="ti-star"></i>
						</div>
					</div>

					<div class="rating-bars">
						<div class="rating-bars-item">
							<span class="rating-bars-name">Service</span>
							<span class="rating-bars-inner">
								<span class="rating-bars-rating high" data-rating="4.7">
									<span class="rating-bars-rating-inner" style="width: 85%;"></span>
								</span>
								<strong>4.7</strong>
							</span>
						</div>
						<div class="rating-bars-item">
							<span class="rating-bars-name">Value for Money</span>
							<span class="rating-bars-inner">
								<span class="rating-bars-rating good" data-rating="3.9">
									<span class="rating-bars-rating-inner" style="width: 75%;"></span>
								</span>
								<strong>3.9</strong>
							</span>
						</div>
						<div class="rating-bars-item">
							<span class="rating-bars-name">Location</span>
							<span class="rating-bars-inner">
								<span class="rating-bars-rating mid" data-rating="3.2">
									<span class="rating-bars-rating-inner" style="width: 52.2%;"></span>
								</span>
								<strong>3.2</strong>
							</span>
						</div>
						<div class="rating-bars-item">
							<span class="rating-bars-name">Cleanliness</span>
							<span class="rating-bars-inner">
								<span class="rating-bars-rating poor" data-rating="2.0">
									<span class="rating-bars-rating-inner" style="width:20%;"></span>
								</span>
								<strong>2.0</strong>
							</span>
						</div>
					</div>
				</div>

				<!-- Reviews Comments -->
				<div class="list-single-main-item fl-wrap">
					<div class="list-single-main-item-title fl-wrap">
						<h3>Item Reviews - <span> 3 </span></h3>
					</div>
					<div class="reviews-comments-wrap">
						<!-- reviews-comments-item -->
						<div class="reviews-comments-item">
							<div class="review-comments-avatar">
								<img src="https://via.placeholder.com/400x400" class="img-fluid" alt="">
							</div>
							<div class="reviews-comments-item-text">
								<h4><a href="#">Josaph Manrty</a><span class="reviews-comments-item-date"><i class="ti-calendar theme-cl"></i>27 Oct 2019</span></h4>

								<div class="listing-rating high" data-starrating2="5"><i class="ti-star active"></i><i class="ti-star active"></i><i class="ti-star active"></i><i class="ti-star active"></i><i class="ti-star active"></i><span class="review-count">4.9</span> </div>
								<div class="clearfix"></div>
								<p>" Commodo est luctus eget. Proin in nunc laoreet justo volutpat blandit enim. Sem felis, ullamcorper vel aliquam non, varius eget justo. Duis quis nunc tellus sollicitudin mauris. "</p>
								<div class="pull-left reviews-reaction">
									<a href="#" class="comment-like active"><i class="ti-thumb-up"></i> 12</a>
									<a href="#" class="comment-dislike active"><i class="ti-thumb-down"></i> 1</a>
									<a href="#" class="comment-love active"><i class="ti-heart"></i> 07</a>
								</div>
							</div>
						</div>
						<!--reviews-comments-item end-->

						<!-- reviews-comments-item -->
						<div class="reviews-comments-item">
							<div class="review-comments-avatar">
								<img src="https://via.placeholder.com/400x400" class="img-fluid" alt="">
							</div>
							<div class="reviews-comments-item-text">
								<h4><a href="#">Rita Chawla</a><span class="reviews-comments-item-date"><i class="ti-calendar theme-cl"></i>2 Nov May 2019</span></h4>

								<div class="listing-rating mid" data-starrating2="5"><i class="ti-star active"></i><i class="ti-star active"></i><i class="ti-star active"></i><i class="ti-star active"></i><i class="ti-star"></i><span class="review-count">3.7</span> </div>
								<div class="clearfix"></div>
								<p>" Commodo est luctus eget. Proin in nunc laoreet justo volutpat blandit enim. Sem felis, ullamcorper vel aliquam non, varius eget justo. Duis quis nunc tellus sollicitudin mauris. "</p>
								<div class="pull-left reviews-reaction">
									<a href="#" class="comment-like active"><i class="ti-thumb-up"></i> 12</a>
									<a href="#" class="comment-dislike active"><i class="ti-thumb-down"></i> 1</a>
									<a href="#" class="comment-love active"><i class="ti-heart"></i> 07</a>
								</div>
							</div>
						</div>
						<!--reviews-comments-item end-->

						<!-- reviews-comments-item -->
						<div class="reviews-comments-item">
							<div class="review-comments-avatar">
								<img src="https://via.placeholder.com/400x400" class="img-fluid" alt="">
							</div>
							<div class="reviews-comments-item-text">
								<h4><a href="#">Adam Wilsom</a><span class="reviews-comments-item-date"><i class="ti-calendar theme-cl"></i>10 Nov 2019</span></h4>

								<div class="listing-rating good" data-starrating2="5"><i class="ti-star active"></i><i class="ti-star active"></i><i class="ti-star active"></i><i class="ti-star active"></i><i class="ti-star"></i> <span class="review-count">4.2</span> </div>
								<div class="clearfix"></div>
								<p>" Commodo est luctus eget. Proin in nunc laoreet justo volutpat blandit enim. Sem felis, ullamcorper vel aliquam non, varius eget justo. Duis quis nunc tellus sollicitudin mauris. "</p>
								<div class="pull-left reviews-reaction">
									<a href="#" class="comment-like active"><i class="ti-thumb-up"></i> 12</a>
									<a href="#" class="comment-dislike active"><i class="ti-thumb-down"></i> 1</a>
									<a href="#" class="comment-love active"><i class="ti-heart"></i> 07</a>
								</div>
							</div>
						</div>
						<!--reviews-comments-item end-->

					</div>
				</div>

				<!-- Add Review Wrap -->
				<div class="block-wrap">

					<div class="block-header">
						<h4 class="block-title">Add Review</h4>
					</div>

					<div class="block-body">

						<div class="giv-averg-rate">
							<div class="row">
								<div class="col-lg-8 col-md-8 col-sm-12">
									<div class="row">

										<div class="col-lg-6 col-md-6 col-sm-12">
											<label>Service?</label>
											<div class="rate-stars">
												<input type="checkbox" id="st1" value="1" />
												<label for="st1"></label>
												<input type="checkbox" id="st2" value="2" />
												<label for="st2"></label>
												<input type="checkbox" id="st3" value="3" />
												<label for="st3"></label>
												<input type="checkbox" id="st4" value="4" />
												<label for="st4"></label>
												<input type="checkbox" id="st5" value="5" />
												<label for="st5"></label>
											</div>
										</div>

										<div class="col-lg-6 col-md-6 col-sm-12">
											<label>Value for Money?</label>
											<div class="rate-stars">
												<input type="checkbox" id="vst1" value="1" />
												<label for="vst1"></label>
												<input type="checkbox" id="vst2" value="2" />
												<label for="vst2"></label>
												<input type="checkbox" id="vst3" value="3" />
												<label for="vst3"></label>
												<input type="checkbox" id="vst4" value="4" />
												<label for="vst4"></label>
												<input type="checkbox" id="vst5" value="5" />
												<label for="vst5"></label>
											</div>
										</div>

										<div class="col-lg-6 col-md-6 col-sm-12">
											<label>Cleanliness?</label>
											<div class="rate-stars">
												<input type="checkbox" id="cst1" value="1" />
												<label for="cst1"></label>
												<input type="checkbox" id="cst2" value="2" />
												<label for="cst2"></label>
												<input type="checkbox" id="cst3" value="3" />
												<label for="cst3"></label>
												<input type="checkbox" id="cst4" value="4" />
												<label for="cst4"></label>
												<input type="checkbox" id="cst5" value="5" />
												<label for="cst5"></label>
											</div>
										</div>

										<div class="col-lg-6 col-md-6 col-sm-12">
											<label>Location?</label>
											<div class="rate-stars">
												<input type="checkbox" id="lst1" value="1" />
												<label for="lst1"></label>
												<input type="checkbox" id="lst2" value="2" />
												<label for="lst2"></label>
												<input type="checkbox" id="lst3" value="3" />
												<label for="lst3"></label>
												<input type="checkbox" id="lst4" value="4" />
												<label for="lst4"></label>
												<input type="checkbox" id="lst5" value="5" />
												<label for="lst5"></label>
											</div>
										</div>

									</div>
								</div>

								<div class="col-lg-4 col-md-4 col-sm-12">
									<div class="avg-total-pilx">
										<h4 class="high">4.9</h4>
										<span>Average Ratting</span>
									</div>
								</div>
							</div>
						</div>

						<div class="review-form-box form-submit">
							<form>
								<div class="row">

									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="form-group">
											<label>Name</label>
											<input class="form-control" type="text" placeholder="Your Name">
										</div>
									</div>

									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="form-group">
											<label>Email</label>
											<input class="form-control" type="email" placeholder="Your Email">
										</div>
									</div>

									<div class="col-lg-12 col-md-12 col-sm-12">
										<div class="form-group">
											<label>Review</label>
											<textarea class="form-control ht-140" placeholder="Review"></textarea>
										</div>
									</div>

									<div class="col-lg-12 col-md-12 col-sm-12">
										<div class="form-group">
											<button type="submit" class="btn btn-theme">Submit Review</button>
										</div>
									</div>

								</div>
							</form>
						</div>

					</div>

				</div>

			</div>

			<!-- property Sidebar -->
			<div class="col-lg-4 col-md-12 col-sm-12">

				<div class="verified-list mb-4">
					<i class="ti-check"></i>Verified Listing
				</div>

				<div class="page-sidebar">

					<!-- Agent Detail -->
					<div class="agent-widget">
						<div class="agent-title">
							<div class="agent-photo"><img src="https://via.placeholder.com/400x400" alt=""></div>
							<div class="agent-details">
								<h4><a href="author-detail.html">Shaurya Preet</a></h4>
								<span><i class="ti-view-grid"></i>202 Listings</span>
							</div>
							<div class="clearfix"></div>
						</div>

						<div class="form-group">
							<input type="text" class="form-control" placeholder="Your Name">
						</div>
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Your Email">
						</div>
						<div class="form-group">
							<textarea class="form-control" placeholder="Send Message to author..."></textarea>
						</div>
						<button class="btn btn-theme full-width">Send Message</button>
					</div>
					<!-- Listing Hour Detail -->
					<div class="tr-single-box">
						<div class="tr-single-header listing-hours-header open">
							<h4>
								<i class="lni-timer"></i> Today<span class="listing-hours-status l-open ml-2">Open</span>
								<span class="time-zone ml-2">USA</span>
								<span class="current-time">15:10 PM</span>
							</h4>
						</div>

						<div class="tr-single-body">
							<ul class="listing-hour-day">
								<li>
									<span class="listing-hour-day">Monday</span>
									<span class="listing-hour-time">10:00 - 6:00</span>
								</li>
								<li>
									<span class="listing-hour-day">Tuesday</span>
									<span class="listing-hour-time">10:00 - 6:00</span>
								</li>
								<li>
									<span class="listing-hour-day">Wednesday</span>
									<span class="listing-hour-time">10:00 - 6:00</span>
								</li>
								<li class="active">
									<span class="listing-hour-day">Thursday</span>
									<span class="listing-hour-time">10:00 - 4:00</span>
								</li>
								<li>
									<span class="listing-hour-day">Friday</span>
									<span class="listing-hour-time">10:00 - 6:00</span>
								</li>
								<li>
									<span class="listing-hour-day">Saturday</span>
									<span class="listing-hour-time">Closed</span>
								</li>
								<li>
									<span class="listing-hour-day">Sunday</span>
									<span class="listing-hour-time">10:00 - 6:00</span>
								</li>

							</ul>
						</div>

					</div>

					<!-- Statics Info -->
					<div class="tr-single-box">
						<div class="tr-single-header">
							<h4><i class="ti-bar-chart"></i> Statics Info</h4>
						</div>

						<div class="tr-single-body">
							<ul class="extra-service half">
								<li>
									<div class="icon-box-icon-block">
										<a href="#">
											<div class="icon-box-round">
												<i class="ti-star"></i>
											</div>
											<div class="icon-box-text">
												4.5 Rating
											</div>
										</a>
									</div>
								</li>

								<li>
									<div class="icon-box-icon-block">
										<a href="#">
											<div class="icon-box-round">
												<i class="ti-bookmark"></i>
											</div>
											<div class="icon-box-text">
												20 Bookmark
											</div>
										</a>
									</div>
								</li>

								<li>
									<div class="icon-box-icon-block">
										<a href="#">
											<div class="icon-box-round">
												<i class="ti-eye"></i>
											</div>
											<div class="icon-box-text">
												785 View
											</div>
										</a>
									</div>
								</li>

								<li>
									<div class="icon-box-icon-block">
										<a href="#">
											<div class="icon-box-round">
												<i class="ti-share"></i>
											</div>
											<div class="icon-box-text">
												110 Share
											</div>
										</a>
									</div>
								</li>

								<li>
									<div class="icon-box-icon-block">
										<a href="#">
											<div class="icon-box-round">
												<i class="ti-comment-alt"></i>
											</div>
											<div class="icon-box-text">
												22 comments
											</div>
										</a>
									</div>
								</li>

								<li>
									<div class="icon-box-icon-block">
										<a href="#">
											<div class="icon-box-round">
												<i class="ti-heart"></i>
											</div>
											<div class="icon-box-text">
												20 Likes
											</div>
										</a>
									</div>
								</li>

							</ul>
						</div>

					</div>

					<!-- Business Info -->
					<div class="tr-single-box">
						<div class="tr-single-header">
							<h4><i class="ti-direction"></i> Listing Info</h4>
						</div>

						<div class="tr-single-body">
							<ul class="extra-service">
								<li>
									<div class="icon-box-icon-block">
										<a href="#">
											<div class="icon-box-round">
												<i class="lni-map-marker"></i>
											</div>
											<div class="icon-box-text">
												524 New Ave, CA 548, USA
											</div>
										</a>
									</div>
								</li>

								<li>
									<div class="icon-box-icon-block">
										<a href="#">
											<div class="icon-box-round">
												<i class="lni-phone-handset"></i>
											</div>
											<div class="icon-box-text">
												+1 415-989-1002
											</div>
										</a>
									</div>
								</li>

								<li>
									<div class="icon-box-icon-block">
										<a href="#">
											<div class="icon-box-round">
												<i class="lni-envelope"></i>
											</div>
											<div class="icon-box-text">
												helpsupport.com@finding.com
											</div>
										</a>
									</div>
								</li>

								<li>
									<div class="icon-box-icon-block">
										<a href="#">
											<div class="icon-box-round">
												<i class="lni-world"></i>
											</div>
											<div class="icon-box-text">
												www.myfinding.com
											</div>
										</a>
									</div>
								</li>

							</ul>
						</div>

					</div>
					<!-- Tags -->
					<div class="tr-single-box">
						<div class="tr-single-header">
							<h4><i class="lni-tag"></i> Метки</h4>
						</div>
						<div class="tr-single-body">
							<ul class="extra-service half">
								<?php foreach ($company->tagLinksArray as $tag) : ?>
									<li>
										<div class="icon-box-icon-block">
											<a href="<?php// $tag->name?>">
												<div class="icon-box-round">
													<i class="lni-car-alt"></i>
												</div>
												<div class="icon-box-text">
													<?= $tag ?>
												</div>
											</a>
										</div>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>

					</div>

					<!-- Tags -->
					<div class="tr-single-box">
						<div class="tr-single-header">
							<h4><i class="lni-tag"></i> Tags</h4>
						</div>
						<div class="tr-single-body">
							<ul class="extra-service half">
								<li>
									<div class="icon-box-icon-block">
										<a href="#">
											<div class="icon-box-round">
												<i class="lni-car-alt"></i>
											</div>
											<div class="icon-box-text">
												Car Parking
											</div>
										</a>
									</div>
								</li>

								<li>
									<div class="icon-box-icon-block">
										<a href="#">
											<div class="icon-box-round">
												<i class="lni-signal"></i>
											</div>
											<div class="icon-box-text">
												Wifi
											</div>
										</a>
									</div>
								</li>

								<li>
									<div class="icon-box-icon-block">
										<a href="#">
											<div class="icon-box-round">
												<i class="lni-emoji-happy"></i>
											</div>
											<div class="icon-box-text">
												Wait Staff
											</div>
										</a>
									</div>
								</li>

								<li>
									<div class="icon-box-icon-block">
										<a href="#">
											<div class="icon-box-round">
												<i class="lni-wheelchair"></i>
											</div>
											<div class="icon-box-text">
												Wheelchair
											</div>
										</a>
									</div>
								</li>

								<li>
									<div class="icon-box-icon-block">
										<a href="#">
											<div class="icon-box-round">
												<i class="lni-music"></i>
											</div>
											<div class="icon-box-text">
												Music & Bar
											</div>
										</a>
									</div>
								</li>

								<li>
									<div class="icon-box-icon-block">
										<a href="#">
											<div class="icon-box-round">
												<i class="ti-widget"></i>
											</div>
											<div class="icon-box-text">
												Swimming
											</div>
										</a>
									</div>
								</li>

							</ul>
						</div>

					</div>

				</div>
			</div>

		</div>
	</div>
</section>
<!-- ============================ Property Detail End ================================== -->

<!-- ============================ Newsletter Start ================================== -->
<section class="newsletter theme-bg" style="background-image:url(/reveal/img/bg-new.png)">
	<div class="container">

		<div class="row justify-content-center">
			<div class="col-md-10 col-md-offset-1">
				<div class="sec-heading light center">
					<h2>Get Latest News</h2>
					<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis.</p>
				</div>
			</div>
		</div>

		<div class="row justify-content-center mt-5">
			<div class="col-md-8 col-sm-8 col-md-offset-2 col-sm-offset-2">
				<div class="newsletter-box text-center">
					<div class="input-group">
						<span class="input-group-addon"><span class="ti-email theme-cl"></span></span>
						<input type="text" class="form-control" placeholder="Enter your Email..">
					</div>
					<button type="button" class="btn btn-theme btn-rounded btn-m">subscribe</button>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- ============================ Newsletter End ================================== -->
</div>
<script src="https://api-maps.yandex.ru/2.1/?apikey=23968611-fd0e-4aea-9982-22f92e32a9bf&lang=ru_RU" type="text/javascript"></script>