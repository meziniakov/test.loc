<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use saschati\youtube\YouTube;

$this->title = isset($place->city->name) ? $place->city->name . ', ' . Html::decode($place->title) . ' — фото, описание, контакты на trip2place.com' : Html::decode($place->title) . ' — фото, описание, контакты на trip2place.com';
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

echo yii\helpers\Html::script($schema, ["type" => "application/ld+json"]);

$this->params['breadcrumbs'][] = [
	'label' => Yii::t('frontend', 'Места'),
	'url' => Url::to('/place')
];
$this->params['breadcrumbs'][] = [
	'label' => $place->category->title,
	'url' => Url::to('/place/' . $place->category->slug)
];
$this->params['breadcrumbs'][] = Yii::t('frontend', $place->title);

$images = $place->getImages();

?>
<div class="featured-slick">
	<div class="featured-slick-slide">
		<?php foreach ($images as $img) : ?>
			<div>
				<?= Html::a(Html::img($img->getUrl('560x359'), ['alt' => $img->alt, 'title' => $img->title, 'class' => 'img-fluid mx-auto']), $img->getUrl(), ['class' => 'mfp-gallery']) ?>
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
											<a href="#" class="cl-instagram"><i class="lni-instagram"></i></a>
										</div>
									</div>
								</div>

								<!-- <div class="pr-single-info">
									<a href="JavaScript:Void(0);" data-toggle="tooltip" data-original-title="Get Print"><i class="ti-printer"></i></a>
								</div>
								<div class="pr-single-info">
									<a href="JavaScript:Void(0);" class="compare-button" data-toggle="tooltip" data-original-title="Compare"><i class="ti-control-shuffle"></i></a>
								</div>
								<div class="pr-single-info">
									<a href="JavaScript:Void(0);" class="like-bitt add-to-favorite" data-toggle="tooltip" data-original-title="Add To Favorites"><i class="lni-heart-filled"></i></a>
								</div> -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
	<section class="gray">
		<div class="container">
			<div class="row">
			<?php if (!empty($place->phone) || !empty($place->email) || !empty($place->website) || !empty($place->schedule)) : ?>
				<div class="col-lg-8 col-md-12 col-sm-12">
				<?php else:?>
					<div class="col-lg-12 col-md-12 col-sm-12">
				<?php endif?>
					<div class="block-wrap">
						<div class="block-header">
							<h2 class="block-title">Информация про "<?= $place->title ?>"</h4>
						</div>
						<div class="block-body">
							<p><?= $place->text ?></p>
						</div>
					</div>

					<?php if(!empty($place->youtube_url)):?>
					<div class="block-wrap">
						<div class="block-header">
							<h4 class="block-title">Видео</h4>
						</div>
						<div class="block-body">
							<?php echo YouTube::widget([
								'video' => $place->youtube_url,
								'iframeOptions' => [
									'class' => 'youtube-video'
								],
								'divOptions' => [
									'class' => 'youtube-video-div'
								],
								'height' => 390,
								'width' => '100%',
								'playerVars' => [
									'controls' => YouTube::DISABLE,
									'autoplay' => YouTube::DISABLE,
									'showinfo' => YouTube::DISABLE,
									'start' => 0,
									'end' => 0,
									'loop ' => YouTube::DISABLE,
									'modestbranding' => YouTube::DISABLE,
									'fs' => YouTube::DISABLE,
									'rel' => YouTube::DISABLE,
									'disablekb' => YouTube::DISABLE
								],
								'events' => [
									'onReady' => 'function (event){
                                            event.target.playVideo();
                                }',
								]
							]);
							?>
						</div>
					</div>

					<?php endif?>
					<?php if ($place->address || $place->lng) : ?>
						<div class="block-wrap">
							<div class="block-header">
								<h2 class="block-title">Как добраться</h2>
							</div>
							<div class="block-body">
							<div class="tr-single-body">
								<ul class="extra-service">
									<?php if (!empty($place->lat) && !empty($place->lng)) : ?>
										<li>
											<div class="icon-box-icon-block">
												<div class="icon-box-round">
													<i class="lni-map-marker"></i>
												</div>
												<div style="display:contents">
													<?= $place->lat .', ' . $place->lng?>
												</div>
											</div>
										</li>
									<?php endif ?>
									<?php if (!empty($place->address)) : ?>
										<li>
											<div class="icon-box-icon-block">
												<div class="icon-box-round">
													<i class="lni-map-marker"></i>
												</div>
												<div style="display:contents">
													<?= $place->address ?>
												</div>
											</div>
										</li>
									<?php endif ?>
								</ul>
							</div>
								<div class="map-container">
									<div id="singleMap" data-addres='<?php echo ($addressInJson) ? $addressInJson : "" ?>'></div>
								</div>
							</div>
						</div>
					<?php endif; ?>

					<div class="rating-overview">
					<script id="tripster-widget-171943" src="https://experience.tripster.ru/partner/widget.js?template=horizontal&order=top&width=100%25&num=3&font_size=small&label=place-bottom&version=2&partner=trip2place&widgetbar=true&widgetbar_delay=20&script_id=tripster-widget-171943" async></script>
					</div>
				</div>

<!-- sidebar -->
<?php if (!empty($place->phone) || !empty($place->email) || !empty($place->website) || !empty($place->schedule)) : ?>
				<div class="col-lg-4 col-md-12 col-sm-12">
					<div class="verified-list mb-4">
						<i class="ti-check"></i>Проверенное место
					</div>
					<div class="page-sidebar">
						<?php if (!empty($place->schedule)) : ?>
							<div class="tr-single-box">
								<div class="tr-single-header listing-hours-header open">
									<h4><i class="lni-timer"></i>Режим работы
										<?php $date = new DateTime();
										if ($date->format('H:i') >= '10:00' && $date->format('H:i') <= '19:00') : ?>
											<span class="listing-hours-status l-open ml-2">Открыто</span>
										<?php else : ?>
											<span class="listing-hours-status l-open ml-2">Закрыто</span>
										<?php endif ?>
									</h4>
								</div>
								<div class="tr-single-body">
									<ul class="listing-hour-day">
										<?php $daysweek = [0 => 'Понедельник', 1 => 'Вторник', 2 => 'Среда', 3 => 'Четверг', 4 => 'Пятница', 5 => 'Суббота', 6 => 'Воскресенье']; ?>
										<?php foreach (Json::decode($place->schedule) as $dn => $working) : ?>
											<li>
												<span class="listing-hour-day"><?= $daysweek[$dn] ?></span>
												<span class="listing-hour-time"><?= date('H:i', $working['from']) ?> - <?= date('H:i', $working['to']) ?></span>
											</li>
										<?php endforeach; ?>
									</ul>
								</div>
							</div>
						<?php endif ?>
						<?php if (!empty($place->phone) || !empty($place->email) || !empty($place->website)) : ?>
						<div class="tr-single-box">
							<div class="tr-single-header">
								<h4><i class="ti-direction"></i> Контактные данные</h4>
							</div>
							<div class="tr-single-body">
								<ul class="extra-service">
									<?php if (!empty($place->phone)) : ?>
										<?php foreach ($place->phone as $phone) : ?>
											<li>
												<div class="icon-box-icon-block">
													<div class="icon-box-round">
														<i class="lni-phone-handset"></i>
													</div>
													<div class="icon-box-text">
														<?= Html::a('+' . $phone['phones'], 'tel:' . $phone['phones'], ['rel' => 'nofollow']) ?>
													</div>
												</div>
											</li>
										<?php endforeach; ?>
										<?php endif; ?>
									<?php if (!empty($place->email)) : ?>
										<li>
											<div class="icon-box-icon-block">
												<div class="icon-box-round">
													<i class="lni-envelope"></i>
												</div>
												<div class="icon-box-text">
													<?= Html::mailto($place->email, $place->email, ['rel' => 'nofollow']) ?>
												</div>
											</div>
										</li>
									<?php endif; ?>
									<?php if (!empty($place->website)) : ?>
										<li>
											<div class="icon-box-icon-block">
												<div class="icon-box-round">
													<i class="lni-world"></i>
												</div>
												<div class="icon-box-text">
													<?= Html::a($place->website, $place->website, ['rel' => 'nofollow', 'referrerpolicy' => "unsafe-url", 'target' => "_blank"]) ?>
												</div>
											</div>
										</li>
									<?php endif; ?>
								</ul>
							</div>
						</div>
						<?php endif; ?>
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
													<a href="<? // $tag->name
																		?>">
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
						<?php if (!empty($otherPlace)) : ?>
							<div class="single-widgets widget_thumb_post">
								<h4 class="title">Смотрите также</h4>
								<ul>
									<?php foreach ($otherPlace as $item) : ?>
										<?php $img = $item->getImage(); ?>
										<li>
											<span class="left">
												<?= Html::a(Html::img($img->getUrl('560x359'), ['alt' => $img->title]), ['place/view', 'category' => $item->category->slug, 'city' => ($item->city) ? $item->city->url : null, 'slug' => $item->slug])?>
											</span>
											<span class="right">
												<?= Html::a($item->title,['place/view', 'category' => $item->category->slug, 'city' => ($item->city) ? $item->city->url : null, 'slug' => $item->slug], ['class' => 'feed-title']) ?>
												<!-- <span class="post-date"><i class="ti-calendar"></i>10 Min ago</span> -->
											</span>
										</li>
									<?php endforeach ?>
								</ul>
							</div>
						<?php endif ?>
					</div>
				</div>
				<?php endif ?>
			</div>
		</div>
	</section>
</article>