<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\parser\models\JsonParser */

$this->title = $model->name;
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
        'model' => $model,
        'attributes' => [
            'id',
            'src_id',
            'name',
            'description:ntext',
            'city_name',
            'city_sys_name',
            'city_src_id',
            'street',
            'street_comment',
            'full_address',
            'lat',
            'lng',
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
    ]) ?>

</div>
