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

    <?php if (Yii::$app->controller->action->id == 'chunk') : ?>
        <div class="form-group">
            <?= html::a('Перейти к парсингу','event', ['class' => 'btn btn-primary'])?>
        </div>

        <div class="col-lg-12">
            <p>Выберите файл для разделения его на части.</p>
            <p>Сохранение файлов происходит в папку с именем, равным исходному имени файла.</p>
        </div>
        <?= $form->field($model, 'parts')->textInput()->label('По сколько объектов делить') ?>

        <?= $form->field($model, 'jsonFile')->fileInput() ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('backend', 'Запуск'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    <?php else : ?>

        <div class="form-group">
            <?= html::a('Разделить файл на части','chunk', ['class' => 'btn btn-primary'])?>
        </div>

        <?php
        $files = FileHelper::findFiles(Yii::getAlias('@storage') . '/json/events/');
        sort($files);
        echo $form->field($model, 'jsonFileByURL')->radioList($files,[
            'item' => function($index, $label, $name, $checked, $value) {
                return '<label class="modal-radio" style="display:block;">
                        <input type="radio" name="' . $name . '" value="' . $label . '" tabindex="3">
                        <i></i>
                        <span>' . ucwords($label) . '</span>
                    </label>';
            }
        ]) ?>

        <?php // $form->field($model, 'jsonFileByURL')->checkboxList($files) ?>
        <?= $form->field($model, 'jsonFile')->fileInput() ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('backend', 'Запуск'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

</div>
<?php endif ?>