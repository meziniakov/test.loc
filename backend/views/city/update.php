<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\City */

$this->title = Yii::t('backend', 'Update City: ') . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Cities'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="city-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
