<?php
/* @var $this yii\web\View */

use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = $city->name . ' ' . date('Y') . ' - все о городе с фото и видео на trip2place.com';
?>

<?php echo $this->render('_menu', [
				'city' => $city,
				'title' => $this->title
			]); ?>

<?php if(!empty($city->preview)):?>
<section class="gray">
	<div class="container">
		<div class="row">

			<!-- property main detail -->
			<div class="col-lg-12 col-md-12 col-sm-12">

				<!-- Single Block Wrap -->
				<div class="block-wrap">

					<div class="block-header">
						<h4 class="block-title">Краткая информация о городе</h4>
					</div>

					<div class="block-body">
						<?= $city->preview ?>
					</div>

				</div>

			</div>

		</div>
	</div>
</section>
<?php endif ?>

<?php if(!empty($listing)):?>
<section>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="sec-heading center">
					<h2>Популярные места</h2>
					<p>Выберите подходящие места.</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="owl-carousel owl-theme" id="lists-slide">
				<?php foreach ($listing as $place) : ?>
					<div class="list-slide-box">
						<div class="modern-list ml-2">
							<?php if (isset($model->schedule)) : ?>
								<div class="list-badge now-open">Открыто</div>
							<?php endif ?>
							<div class="grid-category-thumb">
								<?php if (isset($place->city)) : ?>
									<a href="<?= Url::to(['place/view', 'city' => $place->city->url, 'category' => $place->category['slug'], 'slug' => $place->slug]) ?>" class="overlay-cate"><?= Html::img($place->imageRico->getUrl('358x229'), ['class' => 'img-responsive', 'alt' => $place->slug]) ?></a>
								<?php else : ?>
									<a href="<?= Url::to(['place/view', 'category' => $place->category['slug'], 'slug' => $place->slug]) ?>" class="overlay-cate"><?= Html::img($place->imageRico->getUrl('358x229'), ['class' => 'img-responsive', 'alt' => $place->slug]) ?></a>
								<?php endif ?>
								<div class="property_meta">
									<div class="list-rates">
										<i class="ti-star filled"></i>
										<i class="ti-star filled"></i>
										<i class="ti-star filled"></i>
										<i class="ti-star filled"></i>
										<i class="ti-star"></i>
									</div>
									<?php if (isset($place->city)) : ?>
										<h4 class="lst-title"><?= Html::a($place->title, ['place/view', 'category' => $place->category['slug'], 'city' => $place->city->url, 'slug' => $place->slug]) ?><span class="veryfied-author"></span></h4>
									<?php else : ?>
										<h4 class="lst-title"><?= Html::a($place->title, ['place/view', 'category' => $place->category['slug'], 'slug' => $place->slug]) ?></h4>
									<?php endif ?>
								</div>
							</div>
							<div class="modern-list-content">
								<div class="listing-cat">
									<?= Html::a('<i class="' . $place->category['icon'] . ' bg-a"></i>' . $place->category['title'], ['place/category', 'slug' => $place->category['slug']], ['class' => 'cat-icon cl-1']) ?>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<section>
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<h2>Популярные места</h2>
			</div>
		</div>
		<div class="row">
			<!-- Single City Box -->
			<?php foreach ($listing as $place) : ?>
				<div class="col-lg-4 col-md-6 col-sm-12">
					<article class="tourcity-box style-1">
						<div class="tourcity-box-image">
							<figure>
								<?php if (isset($place->city)) : ?>
									<a href="<?= Url::to(['place/view', 'city' => $place->city->url, 'category' => $place->category['slug'], 'slug' => $place->slug]) ?>" class="overlay-cate"><?= Html::img($place->imageRico->getUrl('358x229'), ['class' => 'img-responsive listing-box-img', 'alt' => $place->slug]) ?>
										<div class="list-overlay"></div>
									</a>
								<?php else : ?>
									<a href="<?= Url::to(['place/view', 'category' => $place->category['slug'], 'slug' => $place->slug]) ?>" class="overlay-cate"><?= Html::img($place->imageRico->getUrl('358x229'), ['class' => 'img-responsive listing-box-img', 'alt' => $place->slug]) ?>
										<div class="list-overlay"></div>
									</a>
								<?php endif ?>
								<!-- <div class="entry-bookmark">
									<a href="#" tabindex="-1"><i class="ti-bookmark"></i></a>
								</div>
								<span class="featured-tourcity"><i class="fa fa-star"></i></span> -->
							</figure>
						</div>
						<div class="inner-box">
							<div class="box-inner-ellipsis">
								<?php if (isset($place->city)) : ?>
									<h4 class="entry-title"><?= Html::a($place->title, ['place/view', 'category' => $place->category['slug'], 'city' => $place->city->url, 'slug' => $place->slug]) ?></h4>
								<?php else : ?>
									<h4 class="entry-title"><?= Html::a($place->title, ['place/view', 'category' => $place->category['slug'], 'slug' => $place->slug]) ?></h4>
								<?php endif ?>
								<div class="price-box">
									<div class="tourcity-price fl-right">
										<div class="theme-cl f-bold">
											<?php if (!empty($place->category->slug)) : ?>
												<div class="listing-cat">
													<?= Html::a("<i class='{$place->category->icon} bg-a'></i>" . $place->category->title, ['place/category', 'slug' => $place->category->slug], ['class' => 'cat-icon cl-1']) ?>
												</div>
											<?php endif ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</article>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif ?>

<section>
				<div class="container">
					
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="sec-heading center">
								<h2>Путешествуй по городам 🎉</h2>
								<!-- <p>Top &amp; perfect 200+ location listings.</p> -->
							</div>
						</div>
					</div>
					<div class="row">
						<?php $i = 0; foreach($cities as $city):?>
						<?php // var_dump($city);die;?>
								<div class="col-lg-<?= ($i === 0) ? '8' : '4'?> col-md-8">
									<a href="list-layout-with-sidebar.html" class="img-wrap">
											<div class="img-wrap-content visible">
												<h4><?= $city->name?></h4>
											</div>
										<div class="img-wrap-background" style="background-image: url(<?= $city->imageRico ? $city->imageRico->getUrl('560x359'): ''?>);"></div>
									</a>
								</div>
							<?php $i++; ?>
						<?php endforeach ?>
					</div>
				</div>
			</section>