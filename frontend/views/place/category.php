<?php

use yii\helpers\Url;
use yii\widgets\ListView;

$this->title = isset($place->city) ? $place->city->name . ', ' . Yii::t('frontend', 'все достопримечательности в категории {title}', ['title' => $place->category->title]) : Yii::t('frontend', 'все достопримечательности в категории {title}', ['title' => $place->category->title]);
$this->params['breadcrumbs']['<i></i>'] = [
	'label' => Yii::t('frontend', 'Места'),
	'url' => Url::to('/place')
];
$this->params['breadcrumbs'][] = Yii::t('frontend', $place->category->title);
?>

<div class="container">
	<div class="col-12 p-0">
			<h2>Места, которые стоит посетить в категории <?= $place->category->title ?><?= isset($place->city) ? ' в городе ' . $place->city->name : '' ?></h2>
	</div>
	<div class="col-12 p-0">
		<?= ListView::widget([
			'dataProvider' => $dataProvider,
			//  'options' => ['class' => ['col-md-12 col-sm-12 mt-3']],
			'itemOptions' => ['class' => ['item col-lg-4 col-md-6 col-sm-12 p-0']],
			'itemView' => '_item_view',
			'summary' => 'Показаны записи <strong>{begin} - {end} </strong> из <strong>{totalCount}</strong>',
			'summaryOptions' => ['class' => 'shorting-wrap'],
			'pager' => [
				'class' => \kop\y2sp\ScrollPager::class,
				'triggerTemplate' => '<div class="col-lg-12 text-center">
			<button type="button" class="btn btn-theme btn-rounded btn-m">{text}</button>
		 </div>',
				'triggerText' => '<div class="col-lg-12">Показать ещё...</div>',
				'noneLeftText' => '<div class="col-lg-12">Записей больше нет</div>',
				'spinnerTemplate' => '<div class="col-lg-12 text-center">
			<div class="spinner-grow text-danger" role="status"><span class="sr-only">Loading...</span></div>
			<div class="spinner-grow text-danger" role="status"><span class="sr-only">Loading...</span></div>
			<div class="spinner-grow text-danger" role="status"><span class="sr-only">Loading...</span></div>
			</div>',
			],
		]); ?>
	</div>
</div>
<div class="clearfix"></div>