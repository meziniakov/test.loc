<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
// use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use backend\widgets\TinyMCECallback;
use bs\Flatpickr\FlatpickrWidget;
use dosamigos\selectize\SelectizeTextInput;
use dosamigos\tinymce\TinyMce;


/* @var $this yii\web\View */
/* @var $model common\models\Organization */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="organization-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'lat')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'lng')->textInput(['maxlength' => true]) ?>

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

    <?= $form->field($model, 'tagValues')->widget(SelectizeTextInput::class, [
        'loadUrl' => ['tag/list'],
        'options' => ['class' => 'form-control'],
        'clientOptions' => [
            'plugins' => ['remove_button'],
            'valueField' => 'name',
            'labelField' => 'name',
            'searchField' => ['name'],
            'create' => true,
        ],
    ]) ?>

    <div class="col-sm-6">
        <?= $form->field($model, 'imageFile')->fileInput() ?>
        <?php $img = $model->getImage(); ?>
        <?= Html::img($img->getUrl('300x')) ?>
        <button class="btn btn-default" type="button" data-clear="">
            <span class="glyphicon glyphicon-remove"></span>
        </button>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
        <?php $gallery = $model->getImages(); ?>
        <?php foreach ($gallery as $image) : ?>
            <?= Html::img($image->getUrl('300x')) ?>
        <?php endforeach; ?>
    </div>

    <?= $form->field($model, 'status')->checkbox(['label' => Yii::t('backend', 'Activate')]) ?>

    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(
        $categories,
        'id',
        'title'
    ), ['prompt' => '']) ?>

    <?= $form->field($model, 'published_at')->widget(FlatpickrWidget::class, [
        'locale' => strtolower(substr(Yii::$app->language, 0, 2)),
        'plugins' => [
            'confirmDate' => [
                'confirmIcon' => "<i class='fa fa-check'></i>",
                'confirmText' => 'OK',
                'showAlways' => false,
                'theme' => 'light',
            ],
        ],
        'groupBtnShow' => true,
        'options' => [
            'class' => 'form-control',
        ],
        'clientOptions' => [
            'allowInput' => true,
            'defaultDate' => $model->published_at ? date(DATE_ATOM, $model->published_at) : null,
            'enableTime' => true,
            'time_24hr' => true,
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>