setTimeout(function () {
	var elem = document.createElement('script');
	elem.type = 'text/javascript';
	elem.src = '//api-maps.yandex.ru/2.1/?apikey=5c924fe7-d9d1-44fc-8318-1e5077ccf4c6&lang=ru_RU&onload=init';
	document.getElementsByTagName('body')[0].appendChild(elem);
}, 2000);

function init() {
	var data = $('#singleMap').data('addres')
	var addres = data['addres']
	var lat = data['lat']
	var lng = data['lng']
		var markerIcon2 = {
		url: '/reveal/img/marker.png',
	}

	if(lat && lng) {
		var myMap = new ymaps.Map("singleMap", {
			center: [lat, lng],
			zoom: 15,
			controls: ['geolocationControl'],
			zoomMargin: [10]
		})
	
		var placemark = new ymaps.Placemark([lat, lng])
		myMap.geoObjects.add(placemark)
	} else {
		var myGeocoder = ymaps.geocode(addres);
		myGeocoder.then(
			function (res) {
				var coords = res.geoObjects.get(0).geometry.getCoordinates();

				var myMap = new ymaps.Map("singleMap", {
					center: coords,
					zoom: 10,
					controls: ['geolocationControl']
				})
				var myPlacemark = new ymaps.Placemark(coords, {}, {
					iconLayout: 'default#image',
					iconImageHref: '/reveal/img/marker.png'
				})

				myMap.geoObjects.add(myPlacemark);
			},
			function (err) {
			}
		);
	}
}