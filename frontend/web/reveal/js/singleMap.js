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

	function routeControl(coords) {
		var myMap = new ymaps.Map('singleMap', {
			center: coords,
			zoom: 9,
			controls: ['routePanelControl']
	});
		var control = myMap.controls.get('routePanelControl');
		control.routePanel.state.set({
			type: "AUTO",
			fromEnabled: true,
			// from: 'Москва, Льва Толстого 16',
			toEnabled: false,
			to: coords
		});

		control.routePanel.options.set({
			allowSwitch: true,
			reverseGeocoding: true,
			types: { auto: true, masstransit: true, pedestrian: true, taxi: true }
		});
	}

	if (lat && lng) {
		var coords = [lat, lng]
		var placemark = new ymaps.Placemark(coords)
		routeControl(coords)
		// myMap.geoObjects.add(placemark);
	} else {
		var myGeocoder = ymaps.geocode(addres);
		myGeocoder.then(function (res) {
			var coords = res.geoObjects.get(0).geometry.getCoordinates();
			var placemark = new ymaps.Placemark(coords, {}, {
				iconLayout: 'default#image',
				iconImageHref: '/reveal/img/marker.png'
			})
			routeControl(coords)
		},
			function (err) {
			}
		);
	}
}