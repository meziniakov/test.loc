<?php

/* @var $this yii\web\View */
/* @var $model common\models\Place */

$this->title = Yii::t('backend', 'Create Place');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Places'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="place-create">

    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
        'cities' => $cities
    ]) ?>

</div>
