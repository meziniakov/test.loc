<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model backend\modules\parser\models\JsonParser */

// $script = <<< JS
// $(document).ready(function() {
//     setInterval(function(){
//         $('#refreshButton').click();
//     }, 3000);
// });
// JS;
// $this->registerJs($script);

// $this->title = $place->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Json Parsers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="json-parser-view">

  <h1><?= Html::encode($this->title) ?></h1>

  <div class="json-parser-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
      <?= html::a('Перейти к парсингу', 'event', ['class' => 'btn btn-primary']) ?>
    </div>

    <div class="col-lg-12" id='my-captcha-image'>
      <?php
      foreach ($output as $key => $item) {
        echo $item . "<br>";
      }
      ?>
    </div>

    <div class="form-group">
      <?php Pjax::begin(); ?>
      <?= Html::a(
        'Обновить',
        ['/parser/json/info'],
        ['class' => 'btn btn-lg btn-primary', 'id' => 'refreshButton']
      ) ?>
      <?= Html::a(
        'Запустить (Run)',
        ['/parser/json/pjax-run'],
        ['class' => 'btn btn-lg btn-primary', 'id' => 'runButton']
      ) ?>
      <?= Html::a(
        'Очистить (Clear)',
        ['/parser/json/pjax-clear'],
        ['class' => 'btn btn-lg btn-primary', 'id' => 'runButton']
      ) ?>
      <p>Время сервера: <?= $time ?></p>
      <?php Pjax::end(); ?>
    </div>

    <?php ActiveForm::end(); ?>

  </div>