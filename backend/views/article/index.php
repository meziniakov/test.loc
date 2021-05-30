<?php

use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\Article;
use common\models\ArticleCategory;
use common\models\City;
use nickdenry\grid\toggle\components\RoundSwitchColumn;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Articles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <p>
        <?= Html::a(Yii::t('backend', 'Create article'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('backend', 'Сгенерировать статью'), ['generate'], ['class' => 'btn btn-warning']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
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
                'value' => function (Article $model) {
                    return Html::a(Html::encode($model->title), Url::to(['update', 'id' => $model->id]));
                },
                'format' => 'raw',
            ],
            // 'slug',
            // 'description',
            // 'keywords',
            // 'body:ntext',
            [
                'class' => RoundSwitchColumn::class,
                'attribute' => 'status',
                'action' => 'switch',
                // 'headerOptions' => ['width' => 150],
            ],
            [
                'attribute' => 'category_id',
                'value' => function ($model) {
                    return $model->category ? $model->category->title : null;
                },
                'filter' => ArrayHelper::map(ArticleCategory::find()->all(), 'id', 'title'),
            ],
            [
                'attribute' => 'city_id',
                'value' => function ($model) {
                    return $model->city ? $model->city->name : null;
                },
                'filter' => ArrayHelper::map(City::find()->all(), 'id', 'name'),
            ],
            // [
            //     'attribute' => 'author_id',
            //     'value' => function ($model) {
            //         return $model->author->username;
            //     },
            // ],
            // 'updater_id',
            // 'published_at',
            // 'created_at',
            // 'updated_at'
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
    ]) ?>

</div>
