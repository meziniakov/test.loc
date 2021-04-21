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
<div class="fs-container half-map">

	<div class="fs-left-map-box">
		<div class="home-map fl-wrap">
			<div class="map-container fw-map">
				<div id="map-main" data-addres='<?php echo ($addressInJson) ? $addressInJson : "" ?>'></div>
			</div>
		</div>
	</div>

	<div class="fs-inner-container">
		<div class="fs-content">

			<div class="justify-content-center">
				<?php echo $this->render('_search', [
					'model' => $dataProvider,
					'tags' => $tags,
					'categories' => $categories,
				]); ?>

			</div>

			<div class="row">
				<?= ListView::widget([
					'dataProvider' => $dataProvider,
					'options' => ['class' => ['list-view col-md-12 col-sm-12']],
					'itemOptions' => ['class' => ['item col-lg-6 col-md-12 col-sm-12']],
					'itemView' => '_item_view',
					'summary' => 'Показаны записи <strong>{begin} - {end} из {totalCount}</strong>',
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
						'eventOnLoad' => "function() {
							$('.list-view').append('<div class=\"spinner\"></div>');
							}",
					],
				]); ?>
			</div>
		</div>
	</div>

</div>
<div class="clearfix"></div>
<!-- Map -->
<script async src="https://api-maps.yandex.ru/2.1/?apikey=23968611-fd0e-4aea-9982-22f92e32a9bf&load=package.standard&lang=ru_RU&onload=init" type="text/javascript"></script>