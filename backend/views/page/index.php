<?php

use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\Page;
use nickdenry\grid\toggle\components\RoundSwitchColumn;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Pages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">

    <p>
        <?= Html::a(Yii::t('backend', 'Create page'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
                'value' => function (Page $model) {
                    return Html::a(Html::encode($model->title), Url::to(['update', 'id' => $model->id]));
                },
                'format' => 'raw',
            ],
            // 'slug',
            // 'description',
            // 'keywords',
            // 'body',
            [
                'class' => RoundSwitchColumn::class,
                'attribute' => 'status',
                'action' => 'switch',
                // 'headerOptions' => ['width' => 150],
            ],
            // 'created_at',
            // 'updated_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
            ],
        ],
    ]) ?>

</div>
