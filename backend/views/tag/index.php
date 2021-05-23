<?php

use common\models\Tag;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\TagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Tags');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-index">

    <p>
        <?= Html::a(Yii::t('backend', 'Create tag'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'value' => function (Tag $model) {
                    return Html::a(Html::encode($model->name), Url::to(['update', 'id' => $model->id]));
                },
                'format' => 'raw',
            ],
            'frequency',
            'slug',
            'comment',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
            ],
        ],
    ]) ?>

</div>
