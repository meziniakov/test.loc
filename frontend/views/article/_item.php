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
<!-- Single blog Grid -->
<div class="col-lg-4 col-md-6">
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

<!-- Single blog Grid -->
<div class="col-lg-4 col-md-6">
    <div class="blog-wrap-grid">

        <div class="blog-thumb">
            <a href="blog-detail.html"><img src="https://via.placeholder.com/1200x850" class="img-fluid" alt="" /></a>
        </div>

        <div class="blog-info">
            <span class="post-date"><i class="ti-calendar"></i>10 August 2018</span>
        </div>

        <div class="blog-body">
            <h4 class="bl-title"><a href="blog-detail.html">List of benifits and impressive listeo services</a></h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore. </p>
            <a href="blo-detail.html" class="bl-continue">Continue</a>
        </div>

    </div>
</div>

<!-- Single blog Grid -->
<div class="col-lg-4 col-md-6">
    <div class="blog-wrap-grid">

        <div class="blog-thumb">
            <a href="blog-detail.html"><img src="https://via.placeholder.com/1200x850" class="img-fluid" alt="" /></a>
        </div>

        <div class="blog-info">
            <span class="post-date"><i class="ti-calendar"></i>30 Sep 2018</span>
        </div>

        <div class="blog-body">
            <h4 class="bl-title"><a href="blog-detail.html">What people says about listio properties</a></h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore. </p>
            <a href="blo-detail.html" class="bl-continue">Continue</a>
        </div>

    </div>
</div>

</div>
<!-- /row -->

<!-- Pagination -->
<!-- <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <ul class="pagination p-center">
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">
                    <span class="ti-arrow-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item active"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">...</a></li>
            <li class="page-item"><a class="page-link" href="#">18</a></li>
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <span class="ti-arrow-right"></span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
    </div>
</div> -->

</div>

</section>
<!-- ============================ Agency List End ================================== -->
<!-- ============================ Newsletter Start ================================== -->
<!-- <section class="newsletter theme-bg" style="background-image:url(assets/img/bg-new.png)">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-10 col-md-offset-1">
                <div class="sec-heading light center">
                    <h2>Получайте самые свежие статьи</h2>
                    <p>Мы не будем спамить, не понравится - всегда можно отписаться.</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-md-8 col-sm-8 col-md-offset-2 col-sm-offset-2">
                <div class="newsletter-box text-center">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="ti-email theme-cl"></span></span>
                        <input type="text" class="form-control" placeholder="Введи ваш Email..">
                    </div>
                    <button type="button" class="btn btn-theme btn-rounded btn-m">Подписаться</button>
                </div>
            </div>
        </div>
    </div>
</section> -->
<!-- ============================ Newsletter End ================================== -->