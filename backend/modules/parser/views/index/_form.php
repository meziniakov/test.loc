<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Parser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="parser-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'uri')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'main_tag')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'total_link')->textInput() ?>

    <?= $form->field($model, 'per_block')->textInput() ?>

    <?= $form->field($model, 'user_agent')->textArea(['maxlength' => true]) ?>

    <?= $form->field($model, 'tag_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tag_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tag_city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tag_addres')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tag_image')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tag_attr_image')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tag_category')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tag_category_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tag_category_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tag_tags')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tag_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tag_links')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tag_reviews')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tag_address')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
