<?php

use common\models\PlaceCategory;
use common\models\Place;
use common\models\City;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use nickdenry\grid\toggle\components\RoundSwitchColumn;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PlaceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Places');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="place-index">
<?= $this->render('_menu', ['categories' => $categories, 'cities' => $cities]) ?>
    <?php Pjax::begin(); ?>
    <?php // $this->render('_search', ['model' => $searchModel]);?>

    <?= GridView::widget([
        'id' => 'grid',
        'dataProvider' => $dataProvider,
        // 'layout' => "{sorter}",
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
                'attribute' => 'title',
                'value' => function (Place $data) {
                    return Html::a(Html::encode($data->title), Url::to(['update', 'id' => $data->id]));
                },
                'format' => 'raw',
                'headerOptions' => ['width' => 400],
            ],
            // 'description:ntext',
            [
                'class' => RoundSwitchColumn::class,
                'attribute' => 'is_home',
                'label' => 'На главной',
                'action' => 'switch',
                'headerOptions' => ['width' => 60],
            ],
            [
                'attribute' => 'category_id',
                'value' => function ($model) {
                    return $model->category ? $model->category->title : null;
                },
                'filter' => ArrayHelper::map(PlaceCategory::find()->all(), 'id', 'title'),
                'headerOptions' => ['width' => 100],
            ],
            [
                'attribute' => 'city_id',
                'value' => function ($model) {
                    return $model->city ? $model->city->name : null;
                },
                'filter' => ArrayHelper::map(City::find()->all(), 'id', 'name'),
                'headerOptions' => ['width' => 100],
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date', 'dd.MM.YYYY'],
                'options' => ['width' => '90'],
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'dateFormat' => 'dd.MM.yyyy',
                    'options' => ['width' => '90']
                ]),
            ],
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
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
            ],
        ],
    ]); ?>

    <?php 
        $this->registerJs('
        $(document).ready(function(){
        $(\'#ToDeleted\').click(function(){
            var id = $(\'#grid\').yiiGridView(\'getSelectedRows\');
            $.ajax({
                type: \'POST\',
                url : \'/place/multiple-delete\',
                data : {id: id},
                success : function() {
                $(this).closest(\'tr\').remove(); //удаление строки
                }
            });
        });
        
        });', \yii\web\View::POS_READY);
    ?>

        <?php 
        $this->registerJs('
        $(document).ready(function(){
        $(\'#ChangeStatus\').click(function(){
            var id = $(\'#grid\').yiiGridView(\'getSelectedRows\');
            $.ajax({
                type: \'POST\',
                url : \'/place/multiple-change-status\',
                data : {id: id},
                success : function() {
                $(this).closest(\'tr\').remove(); //удаление строки
                }
            });
        });
        });', \yii\web\View::POS_READY);
    ?>
        <?php Pjax::end(); ?>
</div>