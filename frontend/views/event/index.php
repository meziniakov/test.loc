<?php

use yii\widgets\ListView;

$this->title = Yii::t('frontend', 'Места');

$this->registerJsFile(
	"/reveal/js/ymaps.js",
	$options = ['depends' => [
		'yii\web\YiiAsset',
		'yii\bootstrap\BootstrapAsset',
		]]);
?>
<div class="container">
	<div class="col-12 p-0">
			<h2>Все события на сайте trip2place.com</h2>
	</div>
	<div class="col-12 p-0">
		<?= ListView::widget([
			'dataProvider' => $dataProvider,
			//  'options' => ['class' => ['col-md-12 col-sm-12 mt-3']],
			'itemOptions' => ['class' => ['item col-lg-4 col-md-6 col-sm-12 p-0']],
			'itemView' => '_item_view',
			// 'summary' => 'Показаны записи <strong>{begin} - {end} </strong> из <strong>{totalCount}</strong>',
			// 'summaryOptions' => ['class' => 'shorting-wrap'],
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