<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Json Parsers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="json-parser-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('backend', 'Create Json Parser'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'src_id',
            'name',
            'description:ntext',
            'city_name',
            //'city_sys_name',
            //'city_src_id',
            //'street',
            //'street_comment',
            //'full_address',
            //'lat',
            //'lng',
            //'category_name',
            //'category_sys_name',
            //'image_url:url',
            //'image_alt',
            //'gallery_url:url',
            //'gallery_alt',
            //'tag_name',
            //'tag_sys_name',
            //'working_schedule:ntext',
            //'website',
            //'email:email',
            //'phones',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'headerOptions' => ['style' => 'color:#337ab7'],
                'template' => '{start}{update}{delete}',
                'buttons' => [
                  'start' => function ($url, $model) {
                      return Html::a('<span class="glyphicon glyphicon-fire"></span>', $url, [
                                  'title' => Yii::t('app', 'lead-view'),
                      ]);
                  },
                  'update' => function ($url, $model) {
                      return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                  'title' => Yii::t('app', 'lead-update'),
                      ]);
                  },
                  'delete' => function ($url, $model) {
                      return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                  'title' => Yii::t('app', 'lead-delete'),
                      ]);
                  }
                ]
            ],
    ]]); 
?>


</div>
