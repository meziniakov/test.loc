<?php

use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = [
    'label' => Yii::t('frontend', 'Articles'),
    'url' => Url::to('/article')
];


$this->title = Yii::t('frontend', 'Articles');
?>
<section>
    <div class="container">
        <div class="row">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_item',
                'summary' => false,
            ]) ?>
        </div>
    </div>
</section>