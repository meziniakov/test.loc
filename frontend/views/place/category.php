<?php

// $this->registerJsFile("/reveal/js/map.js", 
// $options = ['depends' => ['frontend\assets\AppAsset']]);

use yii\bootstrap\Html;
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

      <div class="row">

        <div class="col-lg-6 col-md-6 col-sm-12">
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
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="form-group">
            <div class="input-with-icon">
              <select id="choose-city" class="form-control">
                <option value="">&nbsp;</option>
                <option value="1">Los Angeles, CA</option>
                <option value="2">New York City, NY</option>
                <option value="3">Chicago, IL</option>
                <option value="4">Houston, TX</option>
                <option value="5">Philadelphia, PA</option>
                <option value="6">San Antonio, TX</option>
                <option value="7">San Jose, CA</option>
              </select>
              <i class="ti-briefcase theme-cl"></i>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="form-group">
            <div class="input-with-icon">
              <select id="list-category" class="form-control">
                <option value="">&nbsp;</option>
                <option value="1">Spa & Bars</option>
                <option value="2">Restaurants</option>
                <option value="3">Hotels</option>
                <option value="4">Educations</option>
                <option value="5">Business</option>
                <option value="6">Retail & Shops</option>
                <option value="7">Garage & Services</option>
              </select>
              <i class="ti-layers theme-cl"></i>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group" id="module">
            <a role="button" class="collapsed" data-toggle="collapse" href="#advance-search" aria-expanded="false" aria-controls="advance-search"></a>
          </div>
        </div>
        <div class="collapse" id="advance-search" aria-expanded="false" role="banner">
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
        </div>
      </div>
      <!--- Filter List -->
      <div class="row">
        <!-- Filter Result -->
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="shorting-wrap">
            <h5 class="shorting-title">507 Results</h5>
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
      </div>
      <!--- All List -->
      <div class="row">
      <?= ListView::widget([
		 'dataProvider' => $dataProvider,
		//  'options' => ['class' => ['col-md-12 col-sm-12 mt-3']],
     'itemOptions' => ['class' => ['item col-lg-6 col-md-12 col-sm-12']],
     'itemView' => '_item_view',
     'summary' => 'Показаны записи <strong>{begin}</strong> - {end} из {totalCount}',
     'summaryOptions' => ['class' => 'shorting-wrap'],
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
<!-- <script src="https://api-maps.yandex.ru/2.1/?apikey=23968611-fd0e-4aea-9982-22f92e32a9bf&lang=ru_RU" type="text/javascript"></script>
<script>
	ymaps.ready(init);

	function init() {
		var Lng = $('#singleMap').data('longitude');
		var Lat = $('#singleMap').data('latitude');
		var addres = $('#map-main').data('addres');
		// var addres = ["Адрес:ул Б. Хмельницкого",
		// 	"Адрес:Ардатовский район г. Ардатов, Дючкова д. 103",
		// 	"г. о. Саранск, р.п. Луховка-1, Мичурина"
		// ];

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
			console.log(addres[$i]['id']);

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
							'<div class="listing-short-detail"><h4 class="listing-name"><a href="/place/' + addres[$i]['id'] + '">' + addres[$i]['name'] + '</a>' +
							'<i class="list-status ti-check"></i></h4></div></div><div class="price-features-wrapper">' +
							'<div class="listing-price-fx"><h6 class="listing-card-info-price price-prefix"></h6></div>' +
							'<div class="list-fx-features"></div></div></div>' +
							'</div></div></div>',
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
</script> -->