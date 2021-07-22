<?php

use common\models\City;
use common\models\Event;
use common\models\Place;
use nickdenry\grid\toggle\components\RoundSwitchColumn;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Cities');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="city-index">
    <p>
        <?= Html::a(Yii::t('backend', 'Create City'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'id' => 'grid',
        'dataProvider' => $dataProvider,
        // 'layout' => "{emptyCell}",
        'filterModel' => $searchModel,
       'options' => ['class' => 'table-responsive'],
        'tableOptions' => ['class' => 'table table-striped'],
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function () {
                    return [
                        'onchange' => 'var keys = $("#grid").yiiGridView("getSelectedRows");
                                    $(this).parent().parent().toggleClass("danger");'
                    ];
                }
            ],
            [
                'attribute' => 'name',
                'value' => function (City $data) {
                    return Html::a(Html::encode($data->name), Url::to(['update', 'id' => $data->id]));
                },
                'format' => 'raw',
                // 'headerOptions' => ['width' => 400],
            ],
            'ascii_name:ntext',
            'iata:ntext',
            'in_obj_phrase:ntext',
            'from_obj_phrase:ntext',
            // 'places',
            // 'preview',
            // 'organizer',
            //'text',
            //'ageRestriction',
            // 'isFree',
            //'start',
            //'end',
            // 'category_id',
            // 'place_id',
            // 'city_id',
            //'published_at',
            //'created_at',
            // 'placeCount',
            //'author_id',
            //'updater_id',
            [
                'class' => RoundSwitchColumn::class,
                'attribute' => 'status',
                'label' => 'Статус',
                'action' => 'switch',
                'headerOptions' => ['width' => 60],
            ],
            // [
            //     'attribute' => 'category_id',
            //     'value' => function ($model) {
            //         return $model->category ? $model->category->title : null;
            //     },
            //     'filter' => ArrayHelper::map(Category::find()->all(), 'id', 'title'),
            //     'headerOptions' => ['width' => 100],
            // ],
            // [
            //     'attribute' => 'city_id',
            //     'value' => function ($model) {
            //         return $model->city ? $model->city->name : null;
            //     },
            //     'filter' => ArrayHelper::map(City::find()->all(), 'id', 'name'),
            //     'headerOptions' => ['width' => 100],
            // ],
            // [
            //     'attribute' => 'created_at',
            //     'label' => 'Дата создания',
            //     'format' => ['date', 'dd.MM.YYYY'],
            //     'options' => ['width' => '90'],
            //     'filter' => DatePicker::widget([
            //         'model' => $searchModel,
            //         'attribute' => 'created_at',
            //         'dateFormat' => 'dd.MM.yyyy',
            //         'options' => ['width' => '90']
            //     ]),
            // ],
            // [
            //     'attribute' => 'updated_at',
            //     'format' =>  ['date', 'HH:mm dd.MM.YY'],
            //     'options' => ['width' => '90']
            // ],
            [
                'attribute' => 'imageFile',
                'label' => 'Фото',
                // 'format' => 'image',
                'format' => 'html',
                'filter' => false,
                'content' => function ($model) {
                    return ($model->getImage()->getUrl()) ? Html::img($model->getImage()->getUrl('100x')) : '';
                }
            ],
            [
                'attribute' => 'placeCount',
                'label' => 'Места',
                // 'format' => 'image',
                'format' => 'text',
                'filter' => false,
                'content' => function ($model) {
                    return Place::find()->where(['city_id' => $model->id])->count();
                }
            ],
            [
                'attribute' => 'eventCount',
                'label' => 'События',
                // 'format' => 'image',
                'format' => 'html',
                'filter' => false,
                'content' => function ($model) {
                    return Event::find()->where(['city_id' => $model->id])->count();
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
