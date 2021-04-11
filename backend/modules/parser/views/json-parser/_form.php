<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\parser\models\JsonParser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="json-parser-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'src_id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'city_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city_sys_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'city_src_id')->textInput() ?>

    <?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'street_comment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'full_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lat')->textInput() ?>

    <?= $form->field($model, 'lng')->textInput() ?>

    <?= $form->field($model, 'category_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_sys_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image_alt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gallery_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gallery_alt')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tag_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tag_sys_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'working_schedule')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phones')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
