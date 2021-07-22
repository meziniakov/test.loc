<?php
/* @var $this yii\web\View */

use common\models\Place;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->registerMetaTag([
	'rel' => 'preload',
	'as' => 'image',
	'href' => Yii::getAlias('@storageUrl').'/img/surf-city_main.jpeg',
	'imagesrcset' => Yii::getAlias('@storageUrl').'/img/surf-city_main.jpeg 400w, ' . Yii::getAlias('@storageUrl').'/img/surf-city_main.jpeg 800w, '.Yii::getAlias('@storageUrl').'/img/surf-city_main.jpeg 1600w" imagesizes="50vw"',
]);



$this->title = isset($city->name) ? 'Все достопримечательности в городе ' . $city->name : Yii::$app->keyStorage->get('frontend.index.title');
?>

<div class="image-cover hero-banner" style="background:url(<?= Yii::getAlias('@storageUrl') ?>/img/surf-city_main.jpeg) no-repeat;" data-overlay="6">
	<div class="container">

		<h1 class="big-header-capt">Лучшие места в городе <?= isset($city->name) ? $city->name : "" ?></h1>
		<div class="full-search-2 italian-search hero-search-radius box-style">
			<div class="hero-search-content">
				<form method="get" action="<?= Url::to(['place/index']) ?>">
					<div class="row">
						<div class="col-lg-4 col-md-4 col-sm-12 small-padd">
							<div class="form-group">
								<div class="input-with-icon">
									<?= Html::input('text', 'q', '', ['class' => 'form-control b-r', 'placeholder' => 'Искать...']) ?>
									<i class="theme-cl ti-search"></i>
								</div>
							</div>
						</div>

						<div class="col-lg-3 col-md-3 col-sm-6 small-padd">
							<div class="form-group">
								<div class="input-with-icon">
									<?= Html::dropDownList('city_id', null, ArrayHelper::map($cities, 'id', 'name'), ['id' => 'choose-city', 'class' => 'form-control', 'prompt' => 'Выберите город']) ?>
									<i class="theme-cl ti-briefcase"></i>
								</div>
							</div>
						</div>

						<div class="col-lg-3 col-md-3 col-sm-6 small-padd">
							<div class="form-group">
								<div class="input-with-icon">
									<?= Html::dropDownList('category_id', null, ArrayHelper::map($categories, 'id', 'title'), ['id' => 'list-category', 'class' => 'form-control', 'prompt' => '']) ?>
									<i class="theme-cl ti-briefcase"></i>
								</div>
							</div>
						</div>

						<!-- <div class="col-lg-3 col-md-3 col-sm-6 small-padd">
						<div class="form-group">
							<div class="input-with-icon">
								<? // Html::dropDownList('tag_id', null, ArrayHelper::map($tags, 'slug', 'name'), ['id' => 'list-category', 'class' => 'form-control', 'prompt' => '']) 
								?>
								<i class="theme-cl ti-briefcase"></i>
							</div>
						</div>
					</div> -->

						<div class="col-lg-2 col-md-2 col-sm-12 small-padd">
							<div class="form-group">
								<?= Html::submitButton('Поиск', ['class' => 'btn search-btn']) ?>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="help-video">
			<a href="#" class="wt-video"><span class="pulse"></span>Смотреть видео</a>
		</div>
	</div>
</div>
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
					<?php //$img = $place->getImage(); ?>
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
				<?php //$img = $place->getImage(); ?>
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
												<span>Мест: <?= $places->where(['city_id' => $city->id])->count() ?></span>
											</div>
										<div class="img-wrap-background" style="background-image: url(<?= $city->imageRico->getUrl('560x359')?>);"></div>
									</a>
								</div>
							<?php $i++; ?>
						<?php endforeach ?>
					</div>
				</div>
			</section>



<section class="image-cover" style="background:url(<?= Yii::getAlias('@storageUrl') ?>/img/temnikov.jpeg) no-repeat;" data-overlay="8">
	<div class="container">

		<div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="sec-heading center light">
					<h2>Категории мест</h2>
					<p>Выбирайте места по категориям.</p>
				</div>
			</div>
		</div>

		<div class="row">
			<?php foreach ($categories as $category) : ?>
				<div class="col-lg-3 col-md-6 col-sm-12">
					<div class="list-cats-boxr">
						<?php if (isset($category->slug)) : ?>
							<a href="<?= Url::to(['place/category', 'slug' => $category->slug]) ?>" class="category-box">
							<?php else : ?>
								<a href="<?= Url::to(['place/category', 'slug' => $category->type]) ?>" class="category-box">
								<?php endif ?>
								<div class="category-desc">
									<div class="category-icon">
										<i class="<?= $category->icon ?> theme-cl"></i>
										<i class="<?= $category->icon ?> abs-icon"></i>
									</div>
									<div class="category-detail category-desc-text">
										<h4><?= $category->title ?></h4>
										<!-- <p>122 места</p> -->
									</div>
								</div>
								</a>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>