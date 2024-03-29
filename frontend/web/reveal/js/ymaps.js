setTimeout(function () {
	var elem = document.createElement('script');
	elem.type = 'text/javascript';
	elem.src = '//api-maps.yandex.ru/2.1/?apikey=5c924fe7-d9d1-44fc-8318-1e5077ccf4c6&load=package.standard&lang=ru_RU&onload=init';
	document.getElementsByTagName('body')[0].appendChild(elem);
}, 2000);

function init() {
	var myMap = new ymaps.Map("map-main", {
		center: [55.76, 37.64],
		zoom: 15,
		controls: ['geolocationControl'],
		zoomMargin: [10]
	})

	var lng = $('#map-main').data('longitude');
	var lat = $('#map-main').data('latitude');
	var addres = $('#map-main').data('addres');

	var markerIcon = {
		url: '/reveal/img/marker.png',
	}
	for (let $i = 0; $i < addres.length; $i++) {
		var category = addres[$i]['category'] ? addres[$i]['category'] : '';
		var categorySlug = addres[$i]['categorySlug'] ? addres[$i]['categorySlug'] : '';
		var city = addres[$i]['city'] ? addres[$i]['city'] : '';
		var slug = addres[$i]['slug'] ? addres[$i]['slug'] : '';
		var title = addres[$i]['title'] ? addres[$i]['title'] : '';
		var mainImg = addres[$i]['mainImg'] ? addres[$i]['mainImg'] : '';
		var lat = addres[$i]['lat']
		var lng = addres[$i]['lng']

		if (lng) {
			var placemark = new ymaps.Placemark([lat, lng], {
				iconLayout: 'default#image',
				iconImageHref: '/reveal/img/marker.png',
				iconImageHref: markerIcon,
				balloonContentBody: '<div class="map-popup-wrap">' +
					'<div class="map-popup"></div><div class="property-listing property-2">' +
					'<div class="listing-img-wrapper"><div class="list-single-img">' +
					'<a href="/'+ city +'/place/' + categorySlug + '/' + slug + '"><img src="' + mainImg + '" class="img-fluid mx-auto" alt="" /></a></div>' +
					'<span class="property-type">' + category + '</span></div><div class="listing-detail-wrapper pb-0">' +
					'<div class="listing-short-detail"><h4 class="listing-name"><a href="/'+ city +'/place/' + categorySlug + '/' + slug + '">' + title + '</a>' +
					'<i class="list-status ti-check"></i></h4></div></div></div></div></div></div>'
			})
			myMap.geoObjects.add(placemark);
			myMap.setBounds(myMap.geoObjects.getBounds(), { checkZoomRange: true })
				.then(function () {
					if (myMap.getZoom() > 15) myMap.setZoom(15); // Если значение zoom превышает 15, то устанавливаем 15.
				});
		} else {
			var myGeocoder = ymaps.geocode(addres[$i]['addres']).then(
				function (res) {
					var coords = res.geoObjects.get(0).geometry.getCoordinates();

					myPlacemark = new ymaps.Placemark(coords, {
						iconLayout: 'default#image',
						iconImageHref: '/reveal/img/marker.png',
						iconImageHref: markerIcon,
						balloonContentBody: '<div class="map-popup-wrap">' +
							'<div class="map-popup"></div><div class="property-listing property-2">' +
							'<div class="listing-img-wrapper"><div class="list-single-img">' +
							'<a href="/'+ city +'/place/' + categorySlug + '/' + slug + '"><img src="' + mainImg + '" class="img-fluid mx-auto" alt="" /></a></div>' +
							'<span class="property-type">' + category + '</span></div><div class="listing-detail-wrapper pb-0">' +
							'<div class="listing-short-detail"><h4 class="listing-name"><a href="/'+ city +'/place/' + categorySlug + '/' + slug + '">' + title + '</a>' +
							'<i class="list-status ti-check"></i></h4></div></div></div></div></div></div>'
					})
					// myMap.destroy(),

					myMap.geoObjects.add(myPlacemark);
					myMap.setBounds(myMap.geoObjects.getBounds(), { checkZoomRange: true })
						.then(function () {
							if (myMap.getZoom() > 15) myMap.setZoom(15); // Если значение zoom превышает 15, то устанавливаем 15.
						});
				},
				function (request) {
					console.log("ERROR", request);
				}
			);
		}
	}
}