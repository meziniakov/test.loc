<?php

/* @var $this yii\web\View */
/* @var $model common\models\ArticleCategory */

$this->title = Yii::t('backend', 'Update place category: {title}', ['title' => $model->title]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Place categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="article-category-update">

    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
    ]) ?>

</div>
