<?php

use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\parser\models\JsonParser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="json-parser-form">
    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'title')->textInput() ?>
        <?= $form->field($model, 'h1')->textInput() ?>
        <?= $form->field($model, 'description')->textInput() ?>
        <?= $form->field($model, 'preview')->textarea(['rows' => 2])  ?>
        <?= $form->field($model, 'url')->textInput() ?>
        <?= $form->field($model, 'findUrls')->textInput(['placeholder' => '.rt-model-div'])->hint('Родительский класс ссылок, указывается с точкой, например .rt-model-div') ?>
        <?= $form->field($model, 'preSrc')->textInput(['placeholder' => 'https://www.e-katalog.ru/jpg_zoom1/'])->hint('Приставка ссылки до названия самого изображения, например https://www.e-katalog.ru/jpg_zoom1/') ?>
        <?= $form->field($model, 'limitUrls')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('backend', 'Запуск'), ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>
