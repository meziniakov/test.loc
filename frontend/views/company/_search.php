<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\CompanySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
	'action' => ['company/search'],
	'method' => 'get',
	'options' => [
		'data-pjax' => 1
	],
]); ?>
<form method="get" action="<?= Url::to(['company/search']) ?>">
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