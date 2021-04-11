<?php

use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model common\models\ArticleCategory */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('frontend', 'Articles from category {title}', ['title' => $model->title]);
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('frontend', 'Articles'),
    'url' => Url::to('/article')
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('frontend', 'Categories'),
    'url' => Url::to('/article/category')
];
$this->params['breadcrumbs'][] = Yii::t('frontend', '{title}', ['title' => $model->title]);
?>

<section>
    <div class="container">
        <div class="row">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_item',
                'summary' => false,
            ]) ?>
        </div>
    </div>
</section>