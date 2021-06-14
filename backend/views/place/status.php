<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Place;
use common\models\PlaceCategory;
use yii\helpers\ArrayHelper;
use common\models\City;
use nickdenry\grid\toggle\components\RoundSwitchColumn;
use yii\widgets\Pjax;
use yii\jui\DatePicker;

$this->title = Yii::t('backend', 'Places');

$controller = Yii::$app->controller->id;
?>
<?php $this->render('_search', ['model' => $searchModel]);?>

<?= $this->render('_menu',['categories' => $categories, 'cities' => $cities]) ?>

<?php Pjax::begin()?>
<?= GridView::widget([
        'id' => 'grid',
        'dataProvider' => $data,
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
            ],
            [
                'class' => RoundSwitchColumn::class,
                'attribute' => 'is_home',
                'action' => 'switch',
                // 'headerOptions' => ['width' => 150],
            ],
            [
                'attribute' => 'category_id',
                'value' => function ($model) {
                    return $model->category ? $model->category->title : null;
                },
                'filter' => function ($model) {
                  return ArrayHelper::map($model->category, 'id', 'title');
              },
            ],
            [
                'attribute' => 'city_id',
                'value' => function ($model) {
                    return $model->city ? $model->city->name : null;
                },
                'filter' => function ($model) {
                  return ArrayHelper::map($model->city, 'id', 'name');
              },
            ],
            [
              'attribute'=>'created_at',
              'format' => ['date', 'dd.MM.YYYY'],
              'options' => ['width' => '90'],
              'filter' => DatePicker::widget([
                'model' => $searchModel,
                'attribute' => 'created_at',
                'dateFormat' => 'dd.MM.yyyy',
                'options' => ['width' => '90']
              ]),
            ],
            [
                'attribute' => 'imageFile',
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
            $(\'#ToParsed\').click(function(){
              var id = $(\'#grid\').yiiGridView(\'getSelectedRows\');
              $.ajax({
                  type: \'POST\',
                  url : \'/place/multiple-change-status\',
                  data : {id: id, status: 1},
                  success : function() {
                    $(this).closest(\'tr\').remove(); //удаление строки
                  }
              });
            });
            $(\'#ToEdited\').click(function(){
              var id = $(\'#grid\').yiiGridView(\'getSelectedRows\');
              $.ajax({
                  type: \'POST\',
                  url : \'/place/multiple-change-status\',
                  data : {id: id, status: 2},
                  success : function() {
                    $(this).closest(\'tr\').remove(); //удаление строки
                  }
              });
            });
            $(\'#ToPublished\').click(function(){
              var id = $(\'#grid\').yiiGridView(\'getSelectedRows\');
              $.ajax({
                  type: \'POST\',
                  url : \'/place/multiple-change-status\',
                  data : {id: id, status: 3},
                  success : function() {
                    $(this).closest(\'tr\').remove(); //удаление строки
                  }
              });
            });
            $(\'#ToUpdated\').click(function(){
              var id = $(\'#grid\').yiiGridView(\'getSelectedRows\');
              $.ajax({
                  type: \'POST\',
                  url : \'/place/multiple-change-status\',
                  data : {id: id, status: 4},
                  success : function() {
                    $(this).closest(\'tr\').remove(); //удаление строки
                  }
              });
            });
            $(\'#ToTrashed\').click(function(){
              var id = $(\'#grid\').yiiGridView(\'getSelectedRows\');
              $.ajax({
                  type: \'POST\',
                  url : \'/place/multiple-change-status\',
                  data : {id: id, status: 0},
                  success : function() {
                    $(this).closest(\'tr\').remove(); //удаление строки
                  }
              });
            });
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
          });', 
          \yii\web\View::POS_READY);
      ?>
<?php Pjax::end()?>