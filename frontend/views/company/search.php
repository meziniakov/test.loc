<?php

use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\LinkPager;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;

// $this->registerJsFile(
// 	"/reveal/js/ymap.js",
// 	$options = ['depends' => ['frontend\assets\AppAsset']]
// );
?>
<div class="fs-container half-map">

	<div class="fs-left-map-box">
		<div class="home-map fl-wrap">
			<div class="map-container fw-map">
				<div id="map-main" data-addres='<?= (isset($addressInJson)) ? $addressInJson : "" ?>'></div>
			</div>
		</div>
	</div>

	<div class="fs-inner-container">
		<div class="fs-content">
			<div class="justify-content-center">
				<?php $form = ActiveForm::begin([
					'action' => ['company/search'],
					'method' => 'get',
					'options' => [
						'data-pjax' => 1
					],
				]); ?>
				<form method="get" action="<?= Url::to(['company/search']) ?>">

					<div class="col-lg-12 col-md-12 col-sm-12 small-padd">
						<div class="form-group">
							<div class="input-with-icon">
								<?= Html::input('text', 'q', '', ['class' => 'form-control b-r', 'placeholder' => 'Искать...']) ?>
								<i class="theme-cl ti-search"></i>
							</div>
						</div>
					</div>

					<div class="col-lg-5 col-md-5 col-sm-6 small-padd">
						<div class="form-group">
							<div class="input-with-icon">
								<?= Html::dropDownList('category_id', null, ArrayHelper::map($categories, 'id', 'title'), ['id' => 'list-category', 'class' => 'form-control', 'prompt' => '&nbsp;']) ?>
								<i class="theme-cl ti-briefcase"></i>
							</div>
						</div>
					</div>

					<div class="col-lg-5 col-md-5 col-sm-6 small-padd">
						<div class="form-group">
							<div class="input-with-icon">
								<?= Html::dropDownList('tag_id', null, ArrayHelper::map($tags, 'slug', 'name'), ['id' => 'choose-city', 'class' => 'form-control', 'prompt' => '']) ?>
								<i class="theme-cl ti-briefcase"></i>
							</div>
						</div>
					</div>

					<div class="col-lg-2 col-md-2 col-sm-12 small-padd">
						<div class="form-group">
							<?= Html::submitButton('Поиск', ['class' => 'btn search-btn']) ?>
						</div>
					</div>
				</form>
				<?php ActiveForm::end(); ?>
			</div>

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
		'layout' => "{pager}\n{summary}\n{items}\n{pager}",
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
			'noneLeftText' => 'Записей больше нет'
		],
	]); ?>
</div>
</div>
</div>

</div>
<div class="clearfix"></div>
<!-- Map -->
<script src="https://api-maps.yandex.ru/2.1/?apikey=23968611-fd0e-4aea-9982-22f92e32a9bf&lang=ru_RU" type="text/javascript"></script>
<script>
	ymaps.ready(init);

	function init() {
		var Lng = $('#singleMap').data('longitude');
		var Lat = $('#singleMap').data('latitude');
		var addres = $('#map-main').data('addres');

		var markerIcon = {
			url: '/reveal/img/marker.png',
		}
		var myMap = new ymaps.Map("map-main", {
			center: [55.76, 37.64],
			zoom: 10,
			controls: ['geolocationControl']
		})
		// objectManager = new ymaps.ObjectManager({
		// 	// Чтобы метки начали кластеризоваться, выставляем опцию.
		// 	clusterize: true,
		// 	// ObjectManager принимает те же опции, что и кластеризатор.
		// 	gridSize: 32,
		// 	clusterDisableClickZoom: true,
		// 	clusterBalloonContentLayout: 'cluster#balloonCarousel',
		// 	clusterBalloonContentLayoutHeight: '100%',
		// })
		// objectManager.objects.options.set('preset', 'islands#greenDotIcon');
		// // objectManager.clusters.options.set('preset', 'islands#greenClusterIcons');
		// myMap.geoObjects.add(objectManager);

		for (let $i = 0; $i < addres.length; $i++) {
			var myGeocoder = ymaps.geocode(addres[$i]['addres']);

			myGeocoder.then(
				function(res) {
					// Выведем в консоль данные, полученные в результате геокодирования объекта.
					// console.log('Все данные геообъекта: ', res.geoObjects.get(0).geometry.getCoordinates());
					var firstGeoObject = res.geoObjects.get(0);
					var coords = firstGeoObject.geometry.getCoordinates();
					// Область видимости геообъекта.
					// bounds = firstGeoObject.properties.get('boundedBy');

					// firstGeoObject.options.set('preset', 'islands#darkBlueDotIconWithCaption');
					// // Получаем строку с адресом и выводим в иконке геообъекта.
					// firstGeoObject.properties.set('iconCaption', firstGeoObject.getAddressLine());

					myPlacemark = new ymaps.Placemark(coords, {
						iconLayout: 'default#image',
						iconImageHref: markerIcon,
						balloonContentBody: '<div class="map-popup-wrap">' +
							'<div class="map-popup"></div><div class="property-listing property-2">' +
							'<div class="listing-img-wrapper"><div class="list-single-img">' +
							'<a href="' + addres[$i]['id'] + '"><img src="' + addres[$i]['mainImg'] + '" class="img-fluid mx-auto" alt="" /></a></div>' +
							'<span class="property-type">' + addres[$i]['type'] + '</span></div><div class="listing-detail-wrapper pb-0">' +
							'<div class="listing-short-detail"><h4 class="listing-name"><a href="/company/' + addres[$i]['id'] + '">' + addres[$i]['name'] + '</a>' +
							'<i class="list-status ti-check"></i></h4></div></div></div></div></div></div>'
					})

					myMap.geoObjects.add(myPlacemark);
					myMap.setBounds(myMap.geoObjects.getBounds());

				},
				function(request) {
					console.log("ERROR", request);
				}
			);
		}
	}
</script>