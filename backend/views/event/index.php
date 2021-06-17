<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('backend', 'Events');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('backend', 'Create Event'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'slug',
            'preview',
            'organizer',
            //'text',
            //'ageRestriction',
            //'isFree',
            //'start',
            //'end',
            //'category_id',
            //'place_id',
            //'city_id',
            //'published_at',
            //'created_at',
            //'updated_at',
            //'author_id',
            //'updater_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
