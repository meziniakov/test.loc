<?php

use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;

$this->title = $place->title;
$this->registerJsFile(
	"/reveal/js/singleMap.js",
	$options = [
		// 'appendTimestamp' => false,
		'depends' => [
			'yii\web\YiiAsset',
			'yii\bootstrap\BootstrapAsset',
		]
	]
);
?>
<div class="featured-slick">
	<div class="featured-slick-slide">
		<?php $images = $place->getImages(); ?>
		<?php foreach ($images as $img) : ?>
			<div>
				<a href="<?= $img->getUrl('560x359'); ?>" class="mfp-gallery">
					<img src="<?= $img->getUrl('560x359'); ?>" class="img-fluid mx-auto" title="<?= $img->title ?>" alt="<?= $img->alt ?>" />
				</a>
			</div>
		<?php endforeach; ?>
	</div>
</div>

<article>
	<header class="spd-wrap">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12">
					<div class="slide-property-detail">
						<div class="slide-property-first">
							<div class="listname-into">
								<h1><?= $place->title ?>
									<span class="prt-type rent">
										<?= Html::a($place->category['title'], ['place/category', 'slug' => $place->category['slug']], ['class' => 'cat-icon cl-1']) ?>
									</span>
								</h1>
								<span><?= $place->address ? '<i class="lni-map-marker"></i>' . $place->address : '' ?></span>
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
	</header>

	<!-- ============================ Property Detail Start ================================== -->
	<section class="gray">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-12 col-sm-12">
					<div class="block-wrap">
						<div class="block-header">
							<h2 class="block-title">Информация про "<?= $place->title ?>"</h4>
						</div>
						<div class="block-body">
							<p><?= $place->text ?></p>
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
					<?php if ($place->address || $place->lng) : ?>
						<div class="block-wrap">

							<div class="block-header">
								<h4 class="block-title">Местоположение</h4>
							</div>

							<div class="block-body">
								<div class="map-container">
									<div id="singleMap" data-addres='<?php echo ($addressInJson) ? $addressInJson : "" ?>'></div>
								</div>

							</div>
						</div>
					<?php endif; ?>

					<!-- Review Block Wrap -->
					<!-- <div class="rating-overview">
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
					</div> -->

					<!-- Reviews Comments -->
					<div class="list-single-main-item fl-wrap">
						<div class="list-single-main-item-title fl-wrap">
							<h3>Отзывы</h3>
						</div>
						<div class="reviews-comments-wrap">
							<div class="reviews-comments-item">
								<div class="review-comments-avatar">
									<!-- <img src="" class="img-fluid" alt=""> -->
								</div>
								<div class="reviews-comments-item-text">
									<h4><a href="#">Ник Хлебный</a><span class="reviews-comments-item-date"><i class="ti-calendar theme-cl"></i>27 Окт 2020</span></h4>
									<div class="listing-rating high" data-starrating2="5"><i class="ti-star active"></i><i class="ti-star active"></i><i class="ti-star active"></i><i class="ti-star active"></i><i class="ti-star active"></i><span class="review-count">4.9</span> </div>
									<div class="clearfix"></div>
									<p>Отличное место. Ходили всей семьей.</p>
									<div class="pull-left reviews-reaction">
										<a href="#" class="comment-like active"><i class="ti-thumb-up"></i> 12</a>
										<a href="#" class="comment-dislike active"><i class="ti-thumb-down"></i> 1</a>
										<a href="#" class="comment-love active"><i class="ti-heart"></i> 07</a>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="block-wrap">

						<div class="block-header">
							<h4 class="block-title">Добавить отзыв</h4>
						</div>

						<div class="block-body">
							<div class="giv-averg-rate">
								<div class="row">
									<div class="col-lg-8 col-md-8 col-sm-12">
										<div class="row">
											<div class="col-lg-6 col-md-6 col-sm-12">
												<label>Сервис</label>
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
												<label>Стоимость</label>
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
												<label>Удобство</label>
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
												<label>Местоположение</label>
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
											<span>Средний рейтинг</span>
										</div>
									</div>
								</div>
							</div>

							<div class="review-form-box form-submit">
								<form>
									<div class="row">

										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="form-group">
												<label>Имя</label>
												<input class="form-control" type="text" placeholder="Ваше имя">
											</div>
										</div>

										<div class="col-lg-6 col-md-6 col-sm-12">
											<div class="form-group">
												<label>Email</label>
												<input class="form-control" type="email" placeholder="Ваш Email">
											</div>
										</div>

										<div class="col-lg-12 col-md-12 col-sm-12">
											<div class="form-group">
												<label>Отзыв</label>
												<textarea class="form-control ht-140" placeholder="Отзыв"></textarea>
											</div>
										</div>

										<div class="col-lg-12 col-md-12 col-sm-12">
											<div class="form-group">
												<button type="submit" class="btn btn-theme">Отправить отзыв</button>
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
						<i class="ti-check"></i>Проверенное место
					</div>

					<div class="page-sidebar">
						<!-- Agent Detail -->
						<!-- <div class="agent-widget">
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
					</div> -->
						<!-- Listing Hour Detail -->
						<?php if (isset($place->schedule)) : ?>
							<?php //var_dump(Json::decode($place->schedule)); die;?>
							<div class="tr-single-box">
								<div class="tr-single-header listing-hours-header open">
									<h4><i class="lni-timer"></i>Сейчас
										<?php $date = new DateTime();
										if ($date->format('H:i') >= '10:00' && $date->format('H:i') <= '19:00') : ?>
											<span class="listing-hours-status l-open ml-2">Открыто</span>
										<?php else : ?>
											<span class="listing-hours-status l-open ml-2">Закрыто</span>
										<?php endif ?>
										<!-- <span class="current-time"><? $date->format('D');?></span> -->
										<!-- <span class="time-zone ml-2">Россия</span> -->
									</h4>
								</div>
								<div class="tr-single-body">
									<ul class="listing-hour-day">
										<?php foreach (Json::decode($place->schedule) as $dn => $working) : ?>
											<li>
												<span class="listing-hour-day"><?= $dn ?></span>
												<span class="listing-hour-time"><?= date('H:i', $working['from']) ?> - <?= date('H:i', $working['to']) ?></span>
											</li>
										<?php endforeach; ?>
									</ul>
								</div>
							</div>
						<?php endif ?>

						<div class="tr-single-box">
							<div class="tr-single-header">
								<h4><i class="ti-bar-chart"></i> Статистика</h4>
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

						<div class="tr-single-box">
							<div class="tr-single-header">
								<h4><i class="ti-direction"></i> Информация</h4>
							</div>

							<div class="tr-single-body">
								<ul class="extra-service">
									<li>
										<?php if ($place->address) : ?>
											<div class="icon-box-icon-block">
												<a href="#">
													<div class="icon-box-round">
														<i class="lni-map-marker"></i>
													</div>
													<div style="display:contents">
														<?= $place->address ?>
													</div>
												</a>
											</div>
										<?php endif ?>
									</li>
									<?php if (isset($place->phone)) : ?>
										<?php foreach ($place->phone as $phone) : ?>
											<li>
												<div class="icon-box-icon-block">
													<a href="tel:+<?= $phone['phones'] ?>">
														<div class="icon-box-round">
															<i class="lni-phone-handset"></i>
														</div>
														<div class="icon-box-text">
															<?= '+' . $phone['phones'] ?>
														</div>
													</a>
												</div>
											</li>
										<?php endforeach; ?>
									<?php endif; ?>
									<?php if (isset($place->email)) : ?>
										<li>
											<div class="icon-box-icon-block">
												<a href="#">
													<div class="icon-box-round">
														<i class="lni-envelope"></i>
													</div>
													<div class="icon-box-text">
														<?= $place->email ?>
													</div>
												</a>
											</div>
										</li>
									<?php endif; ?>
									<?php if (isset($place->keywords)) : ?>
										<li>
											<div class="icon-box-icon-block">
												<a href="<?= $place->keywords ?>">
													<div class="icon-box-round">
														<i class="lni-world"></i>
													</div>
													<div class="icon-box-text">
														<?= $place->keywords ?>
													</div>
												</a>
											</div>
										</li>
									<?php endif; ?>
								</ul>
							</div>

						</div>
						<!-- Tags -->
						<?php if ($place->tagLinksArray) : ?>
							<div class="tr-single-box">
								<div class="tr-single-header">
									<h4><i class="lni-tag"></i> Метки</h4>
								</div>
								<div class="tr-single-body">
									<ul class="extra-service half">
										<?php foreach ($place->tagLinksArray as $tag) : ?>
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
						<?php endif ?>
					</div>
				</div>
			</div>
		</div>
	</section>
</article>