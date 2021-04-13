<?php

use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;

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
				<?php $form = ActiveForm::begin([
					'action' => ['place/search'],
					'method' => 'get',
					'options' => [
						'data-pjax' => 1
					],
				]); ?>
				<form method="get" action="<?= Url::to(['place/search']) ?>">

					<div class="col-lg-12 col-md-12 col-sm-12 small-padd">
						<div class="form-group">
							<div class="input-with-icon">
								<?= Html::input('text', 'q', '', ['class' => 'form-control b-r', 'placeholder' => 'Искать...']) ?>
								<i class="theme-cl ti-search"></i>
							</div>
						</div>
					</div>

					<div class="col-lg-5 col-md-5 col-sm-6 small-padd">
						<div class="form-group">
							<div class="input-with-icon">
								<?= Html::dropDownList('category_id', null, ArrayHelper::map($categories, 'id', 'title'), ['id' => 'list-category', 'class' => 'form-control', 'prompt' => '&nbsp;']) ?>
								<i class="theme-cl ti-briefcase"></i>
							</div>
						</div>
					</div>

					<div class="col-lg-5 col-md-5 col-sm-6 small-padd">
						<div class="form-group">
							<div class="input-with-icon">
								<?= Html::dropDownList('tag_id', null, ArrayHelper::map($tags, 'slug', 'name'), ['id' => 'choose-city', 'class' => 'form-control', 'prompt' => '']) ?>
								<i class="theme-cl ti-briefcase"></i>
							</div>
						</div>
					</div>

					<div class="col-lg-2 col-md-2 col-sm-12 small-padd">
						<div class="form-group">
							<?= Html::submitButton('Поиск', ['class' => 'btn search-btn']) ?>
						</div>
					</div>
				</form>
				<?php ActiveForm::end(); ?>
			</div>
      <!--- All List -->
      <div class="row">
      <?= ListView::widget([
		 'dataProvider' => $dataProvider,
		//  'options' => ['class' => ['col-md-12 col-sm-12 mt-3']],
     'itemOptions' => ['class' => ['item col-lg-6 col-md-12 col-sm-12']],
     'itemView' => '_item_view',
     'summary' => 'Показаны записи <strong>{begin} - {end} </strong> из <strong>{totalCount}</strong>',
     'summaryOptions' => ['class' => 'shorting-wrap'],
		 'pager' => [
			'class' => \kop\y2sp\ScrollPager::class,
			'triggerTemplate' => '<div class="text-center">
			<button type="button" class="btn btn-theme btn-rounded btn-m">{text}</button>
		 </div>',
			'triggerText' => 'Показать ещё...',
			'spinnerTemplate' => '<div class="text-center">
			<div class="spinner-grow text-danger" role="status"><span class="sr-only">Loading...</span></div>
			<div class="spinner-grow text-danger" role="status"><span class="sr-only">Loading...</span></div>
			<div class="spinner-grow text-danger" role="status"><span class="sr-only">Loading...</span></div>
			</div>',
		],
]); ?>
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>