<?php

use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model common\models\Tag */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('frontend', 'Tags from category {title}', ['title' => $model->title]);
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('frontend', 'Articles'),
    'url' => Url::to('/article')
];
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('frontend', 'Tags'),
    'url' => Url::to('/article/tag')
];
$this->params['breadcrumbs'][] = Yii::t('frontend', '{title}', ['title' => $model->title]);?>

<section>
    <div class="container">
    <h1><?= Yii::t('frontend', 'Articles tagged with &laquo;{title}&raquo;', ['title' => $model->title]) ?></h1>
        <div class="row">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_item',
                'summary' => false,
            ]) ?>
        </div>
    </div>
</section>
