<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Parsers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parser-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Parser', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <?= Yii::$app->session->getFlash('success'); ?>
    </div>
<?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'uri',
            'main_tag',
            'total_link',
            'user_agent:ntext',
            //'tag_name',
            //'tag_description:ntext',
            //'tag_city',
            //'tag_addres',
            //'tag_image',
            //'tag_attr_image',
            //'tag_category',
            //'tag_category_title',
            //'tag_category_description:ntext',
            //'tag_tags',
            //'tag_phone',
            //'tag_links',
            //'tag_reviews',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
