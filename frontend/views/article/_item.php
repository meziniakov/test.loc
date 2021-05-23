<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use common\assets\Highlight;
use yii\helpers\Url;

/**
 * @var yii\web\View
 * @var common\models\Article
 */

Highlight::register($this);
?>
<div class="col-sm-12 col-md-6 col-lg-4">
    <div class="blog-wrap-grid">
        <div class="blog-thumb">
        <?php $img = $model->getImage(); ?>
            <a href="<?= Url::to(['article/view', 'slug' => ($model->slug) ? $model->slug : $model->id]) ?>">
                <?= Html::img($img->getUrl('358x229'), ['class' => 'img-responsive', 'alt' => $model->slug]) ?>
            </a>
        </div>
        <div class="blog-body">
            <h3 class="bl-title"><?= Html::a($model->title, ['view', 'slug' => $model->slug]) ?></h3>
        </div>
        <div class="blog-info">
            <span class="post-date"><i class="ti-calendar"></i><?= Yii::$app->formatter->asDate($model->published_at, 'long') ?></span>
        </div>
    </div>
</div>