<?php

use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\LinkPager;
use yii\widgets\ListView;

$this->registerJsFile(
	"/reveal/js/ymaps.js",
	$options = ['depends' => [
		'yii\web\YiiAsset',
		'yii\bootstrap\BootstrapAsset',
		]]);
?>
<div class="fs-container half-map">

	<div class="fs-left-map-box">
		<div class="home-map fl-wrap">
			<div class="map-container fw-map">
				<div id="map-main" data-addres='<?php echo ($addressInJson) ? $addressInJson : "" ?>'></div>
			</div>
		</div>
	</div>

	<div class="fs-inner-container">
		<div class="fs-content">

			<div class="justify-content-center">
				<?php echo $this->render('_search', [
					'model' => $dataProvider,
					'tags' => $tags,
					'categories' => $categories,
				]); ?>

				<!-- <div class="col-lg-6 col-md-6 col-sm-12">
								<div class="form-group">
									<div class="input-with-icon">
										<input type="text" class="form-control" placeholder="Keyword...">
										<i class="ti-search theme-cl"></i>
									</div>
								</div>
							</div>
							
							<div class="col-lg-6 col-md-6 col-sm-12">
								<div class="form-group">
									<div class="input-with-icon">
										<input type="text" class="form-control" placeholder="Where...">
										<i class="ti-target theme-cl"></i>
									</div>
								</div>
							</div> -->

				<!-- <div class="col-md-12">
								<div class="form-group" id="module">
									<a role="button" class="collapsed" data-toggle="collapse" href="#advance-search" aria-expanded="false" aria-controls="advance-search"></a>
								</div>
							</div> -->

				<!-- <div class="collapse" id="advance-search" aria-expanded="false" role="banner">

					<div class="col-lg-12 col-md-12 col-sm-12">
						<h4>Amenities & Features</h4>
						<ul class="no-ul-list third-row">
							<li>
								<input id="a-1" class="checkbox-custom" name="a-1" type="checkbox">
								<label for="a-1" class="checkbox-custom-label">Air Condition</label>
							</li>
							<li>
								<input id="a-2" class="checkbox-custom" name="a-2" type="checkbox">
								<label for="a-2" class="checkbox-custom-label">Bedding</label>
							</li>
							<li>
								<input id="a-3" class="checkbox-custom" name="a-3" type="checkbox">
								<label for="a-3" class="checkbox-custom-label">Heating</label>
							</li>
							<li>
								<input id="a-4" class="checkbox-custom" name="a-4" type="checkbox">
								<label for="a-4" class="checkbox-custom-label">Internet</label>
							</li>
							<li>
								<input id="a-5" class="checkbox-custom" name="a-5" type="checkbox">
								<label for="a-5" class="checkbox-custom-label">Microwave</label>
							</li>
							<li>
								<input id="a-6" class="checkbox-custom" name="a-6" type="checkbox">
								<label for="a-6" class="checkbox-custom-label">Smoking Allow</label>
							</li>
							<li>
								<input id="a-7" class="checkbox-custom" name="a-7" type="checkbox">
								<label for="a-7" class="checkbox-custom-label">Terrace</label>
							</li>
							<li>
								<input id="a-8" class="checkbox-custom" name="a-8" type="checkbox">
								<label for="a-8" class="checkbox-custom-label">Balcony</label>
							</li>
							<li>
								<input id="a-9" class="checkbox-custom" name="a-9" type="checkbox">
								<label for="a-9" class="checkbox-custom-label">Icon</label>
							</li>
							<li>
								<input id="a-10" class="checkbox-custom" name="a-10" type="checkbox">
								<label for="a-10" class="checkbox-custom-label">Wi-Fi</label>
							</li>
							<li>
								<input id="a-11" class="checkbox-custom" name="a-11" type="checkbox">
								<label for="a-11" class="checkbox-custom-label">Beach</label>
							</li>
							<li>
								<input id="a-12" class="checkbox-custom" name="a-12" type="checkbox">
								<label for="a-12" class="checkbox-custom-label">Parking</label>
							</li>
						</ul>
					</div>

				</div> -->

			</div>

			<!--- Filter List -->
			<!-- <div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12">
					<div class="shorting-wrap">
						<h5 class="shorting-title"><?php (isset($city) ? "Город:" . $city : "") ?></h5>
						<div class="shorting-right">
										<label>Short By:</label>
										<div class="dropdown show">
											<a class="btn btn-filter dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<span class="selection">Most Rated</span>
											</a>
											<div class="drp-select dropdown-menu">
												<a class="dropdown-item" href="JavaScript:Void(0);">Most Rated</a>
												<a class="dropdown-item" href="JavaScript:Void(0);">Most Viewd</a>
												<a class="dropdown-item" href="JavaScript:Void(0);">News Listings</a>
												<a class="dropdown-item" href="JavaScript:Void(0);">High Rated</a>
											</div>
										</div>
									</div>
					</div>
				</div>
			</div> -->

			<!--- All List -->
			<div class="row">
				<?= ListView::widget([
					'dataProvider' => $dataProvider,
					'options' => ['class' => ['list-view col-md-12 col-sm-12']],
					'itemOptions' => ['class' => ['item col-lg-6 col-md-12 col-sm-12']],
					'itemView' => '_item_view',
					'pager' => [
						'class' => \kop\y2sp\ScrollPager::class,
						'triggerTemplate' => '<div class="text-center">
			<button type="button" class="btn btn-theme btn-rounded btn-m">{text}</button>
		 </div>',
						'triggerText' => 'Показать ещё...',
						'spinnerTemplate' => '<div class="text-center">
			<div class="spinner-grow text-danger" role="status"><span class="sr-only">Loading...</span></div>
			<div class="spinner-grow text-danger" role="status"><span class="sr-only">Loading...</span></div>
			<div class="spinner-grow text-danger" role="status"><span class="sr-only">Loading...</span></div>
			</div>',
					],
				]); ?>
			</div>
		</div>
	</div>

</div>
<div class="clearfix"></div>
<!-- Map -->
<script async src="https://api-maps.yandex.ru/2.1/?apikey=23968611-fd0e-4aea-9982-22f92e32a9bf&load=package.standard&lang=ru_RU&onload=init" type="text/javascript"></script>