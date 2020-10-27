<?php

use yii\bootstrap\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\CompanyCategory;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\CompanyCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Company categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-category-index">

    <p>
        <?= Html::a(Yii::t('backend', 'Create company category'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'title',
            // 'slug',
            'comment',
            [
                'attribute' => 'parent_id',
                'value' => function ($model) {
                    return $model->parent ? $model->parent->title : null;
                },
                'filter' => ArrayHelper::map(CompanyCategory::find()->noParents()->all(), 'id', 'title'),
            ],
            [
                'attribute' => 'status',
                'format' => 'html',
                'value' => function ($model) {
                    return $model->status ? '<span class="glyphicon glyphicon-ok text-success"></span>' : '<span class="glyphicon glyphicon-remove text-danger"></span>';
                },
                'filter' => [
                    CompanyCategory::STATUS_DRAFT => Yii::t('backend', 'Not active'),
                    CompanyCategory::STATUS_ACTIVE => Yii::t('backend', 'Active'),
                ],
            ],
            // 'created_at',
            // 'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]) ?>

</div>
