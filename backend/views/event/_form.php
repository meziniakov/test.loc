<?php

use backend\widgets\TinyMCECallback;
use bs\Flatpickr\FlatpickrWidget;
use common\models\Event;
use dosamigos\selectize\SelectizeTextInput;
use dosamigos\tinymce\TinyMce;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Event */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="event-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <?= Html::a(Yii::t('backend', 'Назад'), ['index'], ['class' => 'btn btn-default']) ?>
        <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>


    <div class="col-sm-6">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true])->hint('Желательно 60-70 символов') ?>
        <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'status')->dropDownList([
            Event::STATUS_PARSED => 'Спарсено',
            Event::STATUS_EDITED => 'Отредактировано',
            Event::STATUS_PUBLISHED => 'Опубликовано',
            Event::STATUS_UPDATED => 'Обновлено',
            Event::STATUS_TRASHED => 'В корзину'
        ]) ?>
        <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(
            $categories,
            'id',
            'title'
        ), ['prompt' => '']) ?>

        <?= $form->field($model, 'city_id')->dropDownList(ArrayHelper::map(
            $cities,
            'id',
            'name'
        ), ['prompt' => '']) ?>

        <?= $form->field($model, 'ageRestriction')->textInput() ?>

        <?= $form->field($model, 'isFree')->textInput() ?>

        <?= $form->field($model, 'start')->widget(FlatpickrWidget::class, [
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
                'defaultDate' => $model->start ? date(DATE_ATOM, $model->start) : null,
                'enableTime' => true,
                'time_24hr' => true,
            ],
        ]) ?>

        <?= $form->field($model, 'end')->widget(FlatpickrWidget::class, [
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
                'defaultDate' => $model->end ? date(DATE_ATOM, $model->end) : null,
                'enableTime' => true,
                'time_24hr' => true,
            ],
        ]) ?>


        <?= $form->field($model, 'tagValues')->widget(SelectizeTextInput::class, [
            'loadUrl' => ['tag/list'],
            'options' => ['class' => 'form-control'],
            'clientOptions' => [
                'plugins' => ['remove_button'],
                'valueField' => 'title',
                'labelField' => 'title',
                'searchField' => ['title'],
                'create' => true,
            ],
        ]) ?>

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
    </div>

    <div class="col-sm-6">
        <?= $form->field($model, 'imageFile')->fileInput()->label('Обложка') ?>
        <?php $img = $model->getImage(); ?>
        <?= Html::img($img->getUrl('300x')) ?>
        <button class="btn btn-default" type="button" data-clear="">
            <span class="glyphicon glyphicon-remove"></span>
        </button>

        <?= $form->field($model, 'organizer')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'place_id')->textInput() ?>

        <?= $form->field($model, 'created_at')->widget(FlatpickrWidget::class, [
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
                'defaultDate' => $model->start ? date(DATE_ATOM, $model->start) : null,
                'enableTime' => true,
                'time_24hr' => true,
            ],
        ]) ?>

        <?= $form->field($model, 'updated_at')->widget(FlatpickrWidget::class, [
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
                'defaultDate' => $model->start ? date(DATE_ATOM, $model->start) : null,
                'enableTime' => true,
                'time_24hr' => true,
            ],
        ]) ?>

        <?= $form->field($model, 'author_id')->textInput() ?>
        <?= $form->field($model, 'updater_id')->textInput() ?>
    </div>

    <div class="col-sm-12">
        <?= $form->field($model, 'preview')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'text')->widget(TinyMce::class, [
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
                <?= Html::a('x', ['/event/deletemoreimg', 'imageId' => $image->id, 'id' => $model->id], ['class' => '']) ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="col-sm-12">
        <div class="form-group">
            <?= Html::submitButton(Yii::t('backend', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
