<?php
/* @var $this yii\web\View */

use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ListView;

$this->title = 'Все достопримечательности в городе ' . $city->name;
?>

<?php echo $this->render('_menu', [
				'city' => $city,
        'title' => $this->title
			]); ?>

<section class="gray">
  <div class="container">
    <div class="row">
      <?= ListView::widget([
        'dataProvider' => $dataProvider,
        //  'options' => ['class' => ['col-md-12 col-sm-12 mt-3']],
        'itemOptions' => ['class' => ['item col-lg-4 col-md-6 col-sm-12 p-0']],
        'itemView' => '_item_view',
        // 'summary' => 'Показаны записи <strong>{begin} - {end} </strong> из <strong>{totalCount}</strong>',
        // 'summaryOptions' => ['class' => 'shorting-wrap'],
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