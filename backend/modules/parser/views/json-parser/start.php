<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\parser\models\JsonParser */

$this->title = $place->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Json Parsers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="json-parser-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $place,
        'attributes' => [
            'id',
            'src_id',
            'title',
            'text:ntext',
            'city_id',
            'city_sys_name',
            'city_src_id',
            'street',
            'street_comment',
            'address',
            'lat',
            'lng',
            'type',
            'keywords',
            'category_name',
            'category_sys_name',
            'image_url:url',
            'image_alt',
            'gallery_url:url',
            'gallery_alt',
            'tag_name',
            'tag_sys_name',
            'working_schedule:ntext',
            'website',
            'email:email',
            'phones',
        ],
        'options' => ['class' => 'table table-striped table-bordered detail-view']
    ]) ?>

</div>
