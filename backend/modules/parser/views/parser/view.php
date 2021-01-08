<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Parser */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Parsers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="parser-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Start', ['pusk', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Test', ['test', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'uri',
            'main_tag',
            'total_link',
            'user_agent:ntext',
            'tag_name',
            'tag_description:ntext',
            'tag_city',
            'tag_addres',
            'tag_image',
            'tag_attr_image',
            'tag_category',
            'tag_category_title',
            'tag_category_description:ntext',
            'tag_tags',
            'tag_phone',
            'tag_links',
            'tag_reviews',
        ],
    ]) ?>

</div>
