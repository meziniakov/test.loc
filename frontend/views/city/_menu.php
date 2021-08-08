<?php
use yii\bootstrap\Html;

$this->params['breadcrumbs'][] = [
	'label' => $city->name,
	'options' => [
			'tag' => 'span',
			'class' => 'choose_city',
			'data-toggle' => "modal",
			'data-target' => "#chooseCity",
	],
	'url' => '#chooseCity'
];

?>
<section class="page-title-banner" style="background-image:url(<?= $city->imageRico ? $city->imageRico->getUrl('1920x'): '' ?>);">
	<div class="container">
		<div class="row m-0 align-items-end detail-swap">
			<div class="tr-list-wrap">
				<div class="tr-list-detail">
					<div class="tr-list-info">
						<h1 class="big-header-capt"><?= $city->name ?></h1>
					</div>
				</div>
				<div class="listing-detail_right">
					<div class="listing-detail-item">
						<a href="#" class="btn btn-list"><i class="ti-heart"></i>В любимые </a>
					</div>
					<div class="listing-detail-item">
						<div class="share-opt-wrap">
							<button type="button" class="btn btn-list" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="ti-share"></i>Поделиться
							</button>
							<div class="dropdown-menu animated flipInX">
								<a href="#" class="cl-facebook"><i class="lni-facebook"></i></a>
								<a href="#" class="cl-twitter"><i class="lni-twitter"></i></a>
								<a href="#" class="cl-gplus"><i class="lni-google-plus"></i></a>
								<a href="#" class="cl-instagram"><i class="lni-instagram"></i></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<div class="container">
		<div class="element-menu">
			<div class="scroll-menu">
				<nav class="scrolling-stone">
					<?= Html::a('Достопримечательности', ['city/dostoprimechatelnosti', 'city' => $city->url])?>
					<?= Html::a('События', ['city/events', 'city' => $city->url])?>
					<?= Html::a('Экскурсии', ['city/gidy', 'city' => $city->url])?>
					<?= Html::a('На карте', ['place/index', 'city' => $city->url])?>
					<!-- <a href="/photo/">Фото</a> -->
					<!-- <a href="/pogoda/">Погода</a> -->
					<!-- <a href="/video/">Видео</a> -->
					<a href="/aviabileti/">Авиабилеты</a>
					<!-- <a href="/russia/moskva/hotel/">Отели</a> -->
				</nav>
			</div>
		</div>
	</div>