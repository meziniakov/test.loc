<?php

use common\models\City;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\PlaceCategory;

/* @var $this yii\web\View */
/* @var $model backend\models\PlaceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="place-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?php // echo $form->field($model, 'id') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?= $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php echo $form->field($model, 'city_id')->dropDownList(ArrayHelper::map(City::find()->all(), 'id', 'url'), ['prompt' => '']) ?>
    <?php echo $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(PlaceCategory::find()->all(), 'id', 'title'), ['prompt' => '']) ?>

    <?php // echo $form->field($model, 'lon') ?>

    <?php // echo $form->field($model, 'lat') ?>

    <?php // echo $form->field($model, 'links_id') ?>

    <?php // echo $form->field($model, 'opinions_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
