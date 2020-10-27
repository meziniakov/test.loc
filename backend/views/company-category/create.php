<?php

/* @var $this yii\web\View */
/* @var $model common\models\ArticleCategory */

$this->title = Yii::t('backend', 'Create company category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Company categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-category-create">

    <?= $this->render('_form', [
        'model' => $model,
        'categories' => $categories,
    ]) ?>

</div>
