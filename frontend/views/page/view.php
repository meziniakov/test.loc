<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

/* @var $this yii\web\View */
/* @var $model common\models\Page */

$this->title = $model->title;
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <h1><?= Html::encode($model->title) ?></h1>
                <!-- <h2 class="ipt-title">Our Articles</h2> -->
                <!-- <span class="ipn-subtitle">See Our Latest Articles & News</span> -->
            </div>
        </div>
    </div>
</div>
<section>
    <div class="container">
        <div class="row">
            <?= HtmlPurifier::process($model->body) ?>
        </div>
    </div>
</section>