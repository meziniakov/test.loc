<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\parser\models\JsonParser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="json-parser-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'jsonFile')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('backend', 'Запуск'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
