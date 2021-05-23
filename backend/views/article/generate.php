<?php

/* @var $this yii\web\View */
/* @var $model common\models\Article */

$this->title = Yii::t('backend', 'Create article');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Articles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-create">

    <?= $this->render('_form_generate', [
        'model' => $model,
        'categories' => $categories,
        'place_categories' => $place_categories,
        'cities' => $cities
    ]) ?>

</div>