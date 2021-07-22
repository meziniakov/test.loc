<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Event */

$this->title = Yii::t('backend', 'Edit') . ' : ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Places'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Edit');
?>
<div class="event-update">

    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
        'cities' => $cities
    ]) ?>

</div>
