<?php
/* @var $this yii\web\View */

use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = Yii::$app->keyStorage->get('frontend.index.title');
?>

<div class="image-cover hero-banner" style="background:url(reveal/img/33.jpg) no-repeat;" data-overlay="6">
	<div class="container">

		<h1 class="big-header-capt">Лучшие места в городе <?= isset($city->name) ? $city->name : "" ?></h1>
		<div class="full-search-2 italian-search hero-search-radius box-style">
			<div class="hero-search-content">
				<div class="row">
					<div class="col-lg-4 col-md-4 col-sm-12 small-padd">
						<div class="form-group">
							<div class="input-with-icon">
								<form method="get" action="<?= Url::to(['place/index']) ?>">
									<?= Html::input('text', 'q', '', ['class' => 'form-control b-r', 'placeholder' => 'Искать...']) ?>
									<i class="theme-cl ti-search"></i>
							</div>
						</div>
					</div>

					<div class="col-lg-3 col-md-3 col-sm-6 small-padd">
						<div class="form-group">
							<div class="input-with-icon">
								<?= Html::dropDownList('city_id', null, ArrayHelper::map($cities, 'id', 'name'), ['id' => 'choose-city', 'class' => 'form-control', 'prompt' => '']) ?>
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
								<?// Html::dropDownList('tag_id', null, ArrayHelper::map($tags, 'slug', 'name'), ['id' => 'list-category', 'class' => 'form-control', 'prompt' => '']) ?>
								<i class="theme-cl ti-briefcase"></i>
							</div>
						</div>
					</div> -->

					<div class="col-lg-2 col-md-2 col-sm-12 small-padd">
						<div class="form-group">
							<?= Html::submitButton('Поиск', ['class' => 'btn search-btn']) ?>
						</div>
						</form>
					</div>
				</div>
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
					<?php $img = $place->getImage(); ?>
					<div class="list-slide-box">
						<div class="modern-list ml-2">
							<?php if (isset($model->schedule)) : ?>
								<div class="list-badge now-open">Открыто</div>
							<?php endif ?>
							<div class="grid-category-thumb">
								<?php if (isset($place->city)) : ?>
									<a href="<?= Url::to(['place/view', 'city' => $place->city->url, 'category' => $place->category['slug'], 'slug' => $place->slug]) ?>" class="overlay-cate"><?= Html::img($img->getUrl('358x229'), ['class' => 'img-responsive', 'alt' => $place->slug]) ?></a>
								<?php else : ?>
									<a href="<?= Url::to(['place/view', 'category' => $place->category['slug'], 'slug' => $place->slug]) ?>" class="overlay-cate"><?= Html::img($img->getUrl('358x229'), ['class' => 'img-responsive', 'alt' => $place->slug]) ?></a>
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
										<h4 class="lst-title"><?= Html::a($place->title, ['place/view', 'category' => $place->category['slug'], 'slug' => $place->slug]) ?><span class="veryfied-author"></span></h4>
									<?php endif ?>
								</div>
							</div>
							<div class="modern-list-content">
								<div class="listing-cat">
									<?= Html::a('<i class=' . $place->category['icon'] . ' bg-a"></i>' . $place->category['title'], ['place/category', 'slug' => $place->category['slug']], ['class' => 'cat-icon cl-1']) ?>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
<section class="image-cover" style="background:url(<?= Yii::getAlias('@storageUrl') ?>/img/1200x850.png) no-repeat;" data-overlay="8">
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