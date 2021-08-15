<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;
use common\assets\Highlight;
use metalguardian\fotorama\Fotorama;

/* @var $this yii\web\View */
/* @var $model common\models\Article */

Highlight::register($this);

$this->params['breadcrumbs'][] = [
	'label' => Yii::t('frontend', 'Articles'),
	'url' => Url::to('/article')
];
?>

<?= $this->render('_form2', [
        'model' => $model,
    ]) ?>


<article class="wallpaper">
	<header class="article-header">
		<div class="article-header__meta">
			<ul class="meta-comment-tag">
			</ul>
		</div>
		<div class="article-header__cover" style="background-image: url()"></div>
		<h1 class="article-header__title"><?= $model->h1 ?></h1>
        <p><?= $model->preview ?></p>
	</header>

	<div class="row post-details">
        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
            <?php foreach ($data as $item):?>
                <h2><?= $item['title']?></h2>
                <img src="<?= $item['img']?>" width="400" alt="">
                <img src="<?= $item['image']?>" width="400" alt="">
                <p><?= $item['text']?></p>
            <?php endforeach; ?>
        </div>
	</div>
</article>