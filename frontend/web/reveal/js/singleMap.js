setTimeout(function () {
	var elem = document.createElement('script');
	elem.type = 'text/javascript';
	elem.src = '//api-maps.yandex.ru/2.1/?apikey=5c924fe7-d9d1-44fc-8318-1e5077ccf4c6&lang=ru_RU&onload=init';
	document.getElementsByTagName('body')[0].appendChild(elem);
}, 2000);

ymaps.ready(init);

	function init() {
		var addres = $('#singleMap').data('addres');

		var markerIcon2 = {
			url: '/reveal/img/marker.png',
		}

		var myGeocoder = ymaps.geocode(addres[0]['addres']);
		myGeocoder.then(
			function(res) {
				var coords = res.geoObjects.get(0).geometry.getCoordinates();
				// console.log(coords);

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
			function(err) {
			}
			
		);
	}