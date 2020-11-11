<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>

<section class="error-wrap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-10">
                <div class="text-center">
                    <img src="/reveal/img/404.png" class="img-fluid" alt="">
                    <p><?= nl2br(Html::encode($message)) ?></p>
                    <?= Html::a('Перейти на главную', '/', ['class' => 'btn btn-theme']) ?>
                </div>
            </div>
        </div>
    </div>
</section>