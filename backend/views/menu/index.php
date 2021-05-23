<?php

use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Menu;
use nickdenry\grid\toggle\components\RoundSwitchColumn;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Menu');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">

    <p>
        <?= Html::a(Yii::t('backend', 'Create item'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            // 'url',
            [
                'attribute' => 'label',
                'value' => function (Menu $model) {
                    return Html::a(Html::encode($model->label), Url::to(['update', 'id' => $model->id]));
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'parent_id',
                'value' => function ($model) {
                    return $model->parent ? $model->parent->label : null;
                },
                'filter' => ArrayHelper::map(Menu::find()->noParents()->all(), 'id', 'label'),
            ],
            [
                'class' => RoundSwitchColumn::class,
                'attribute' => 'status',
                'action' => 'switch',
                // 'headerOptions' => ['width' => 150],
            ],

            // [
            //     'attribute' => 'status',
            //     'format' => 'html',
            //     'value' => function ($model) {
            //         return $model->status ? '<span class="glyphicon glyphicon-ok text-success"></span>' : '<span class="glyphicon glyphicon-remove text-danger"></span>';
            //     },
            //     'filter' => [
            //         Menu::STATUS_DRAFT => Yii::t('backend', 'Not active'),
            //         Menu::STATUS_ACTIVE => Yii::t('backend', 'Active'),
            //     ],
            // ],
            'sort_index',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
            ],
        ],
    ]) ?>

</div>
