<?php
/* @var $this yii\web\View */

use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ListView;
?>

<?php echo $this->render('_menu', [
				'city' => $city,
        'title' => $this->title
			]); ?>

<section class="gray">
  <div class="container">
  <div class="col-12 p-0">
			<h2>Все события на сайте trip2place.com</h2>
	</div>
    <div class="row">
      <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => ['item col-lg-4 col-md-6 col-sm-12 p-0']],
        'itemView' => '_event_item_view',
        'pager' => [
          'class' => \kop\y2sp\ScrollPager::class,
          'triggerTemplate' => '<div class="col-lg-12 text-center">
			<button type="button" class="btn btn-theme btn-rounded btn-m">{text}</button>
		 </div>',
          'triggerText' => '<div class="col-lg-12">Показать ещё...</div>',
          'noneLeftText' => '<div class="col-lg-12">Записей больше нет</div>',
          'spinnerTemplate' => '<div class="col-lg-12 text-center">
			<div class="spinner-grow text-danger" role="status"><span class="sr-only">Loading...</span></div>
			<div class="spinner-grow text-danger" role="status"><span class="sr-only">Loading...</span></div>
			<div class="spinner-grow text-danger" role="status"><span class="sr-only">Loading...</span></div>
			</div>',
        ],
      ]); ?>
</section>
<div class="clearfix"></div>