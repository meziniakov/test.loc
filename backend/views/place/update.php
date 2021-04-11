<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Place */

$this->title = Yii::t('backend', 'Edit') . ' : ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Places'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Edit');
?>
<div class="place-update">

    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
    ]) ?>

</div>
