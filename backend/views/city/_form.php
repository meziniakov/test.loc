<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\widgets\TinyMCECallback;
use dosamigos\tinymce\TinyMce;
use yii\web\JsExpression;


/* @var $this yii\web\View */
/* @var $model common\models\City */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="city-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <?= Html::a(Yii::t('backend', 'Назад'), ['index'], ['class' => 'btn btn-default']) ?>
        <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <div class="col-sm-6">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название города') ?>
        <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'status')->checkbox(['label' => Yii::t('backend', 'Activate')]) ?>
        <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'lat')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'lng')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'youtube_url')->textInput(['maxlength' => true])->hint('пример https://www.youtube.com/watch?v=wnjFKBzyq8k') ?>
    </div>

    <div class="col-sm-6">
        <?= $form->field($model, 'imageFile')->fileInput()->label('Обложка') ?>
        <?php $img = $model->getImage(); ?>
        <?= Html::img($img->getUrl('300x')) ?>
        <button class="btn btn-default" type="button" data-clear="">
            <span class="glyphicon glyphicon-remove"></span>
        </button>
    </div>


    <div class="col-sm-12">
        <div class="col-sm-12">
            <?= $form->field($model, 'preview')->widget(TinyMce::class, [
                'language' => strtolower(substr(Yii::$app->language, 0, 2)),
                'clientOptions' => [
                    'height' => 350,
                    'menubar' => false,
                    'statusbar' => true,
                    'toolbar' => 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | forecolor backcolor',
                    'file_picker_callback' => TinyMCECallback::getFilePickerCallback(['file-manager/frame']),
                ],
            ]) ?>

            <?= $form->field($model, 'description')->widget(TinyMce::class, [
                'language' => strtolower(substr(Yii::$app->language, 0, 2)),
                'clientOptions' => [
                    'height' => 350,
                    'plugins' => [
                        'advlist autolink lists link image charmap print preview anchor pagebreak',
                        'searchreplace visualblocks code fullscreen',
                        'insertdatetime media table contextmenu paste code textcolor colorpicker',
                    ],
                    'toolbar' => 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | forecolor backcolor',
                    'file_picker_callback' => TinyMCECallback::getFilePickerCallback(['file-manager/frame']),
                ],
            ]) ?>

            <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true])->label('Галерея фото') ?>
            <hr>
        </div>

        <div class="col-sm-12">
            <?php $gallery = $model->getImages(); ?>
            <?php foreach ($gallery as $image) : ?>
                <div class="thumbnail">
                    <img src="<?= $image->getUrl('300x') ?>" class="" alt="Image">
                    <?= Html::a('x', ['city/deletemoreimg', 'imageId' => $image->id, 'id' => $model->id], ['class' => '']) ?>
                </div>
            <?php endforeach; ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>