<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('frontend', 'Articles');
// $this->params['breadcrumbs'][] = $this->title;
?>
<!-- ============================ Page Title Start================================== -->
<div class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">

                <h2 class="ipt-title"><?= $this->title ?></h2>
                <span class="ipn-subtitle">See Our Latest Articles & News</span>

            </div>
        </div>
    </div>
</div>
<!-- ============================ Page Title End ================================== -->
<section>
    <div class="container">
        <!-- <div class="row">
            <div class="col text-center">
                <div class="sec-heading center">
                    <h2>Latest News</h2>
                    <p>We post regulary most powerful articles for help and support.</p>
                </div>
            </div>
        </div> -->

        <div class="row">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_item',
                'summary' => false,
            ]) ?>
        </div>
    </div>