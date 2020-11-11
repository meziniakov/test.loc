<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Parser */

$this->title = 'Create Parser';
$this->params['breadcrumbs'][] = ['label' => 'Parsers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parser-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
