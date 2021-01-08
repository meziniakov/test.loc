ymaps.ready(function(){
  var test = new ymaps.Map('map-main',{
    center: [55.76, 37.64],
    zoom: 10,
    controls: ['geolocationControl']    
  });

  objectManager = new ymaps.ObjectManager({
    // Чтобы метки начали кластеризоваться, выставляем опцию.
    clusterize: true,
    // ObjectManager принимает те же опции, что и кластеризатор.
    gridSize: 32,
    clusterDisableClickZoom: true,
    clusterBalloonContentLayout: 'cluster#balloonCarousel',
    clusterBalloonContentLayoutHeight: '100%',

});

objectManager.objects.options.set('preset', 'islands#greenDotIcon');
// objectManager.clusters.options.set('preset', 'islands#greenClusterIcons');
test.geoObjects.add(objectManager);

var url = window.location.href;
$.ajax({
// url: url + "/json"
}).done(function(data) {
objectManager.add(data);
});


$.ajax({
  url: url + "/address",
  success: function (data) {

    for (let index = 0; index < data.length; index++) {
      console.log(data[1]);
      // const element = array[index];
      ymaps.geocode(data[index], {
        results: 1
    }).then(function (res) {
            // Выбираем первый результат геокодирования.
            var firstGeoObject = res.geoObjects.get(0),
                // Координаты геообъекта.
                coords = firstGeoObject.geometry.getCoordinates(),
                // Область видимости геообъекта.
                bounds = firstGeoObject.properties.get('boundedBy');
  
            firstGeoObject.options.set('preset', 'islands#darkBlueDotIconWithCaption');
            // Получаем строку с адресом и выводим в иконке геообъекта.
            firstGeoObject.properties.set('iconCaption', firstGeoObject.getAddressLine());
  

          var placemark = new ymaps.Placemark(coords, {
            balloonContentHeader: '',
            balloonContentBody:
            '<div class="map-popup-wrap">' +
            '<div class="map-popup"><div class="infoBox-close">' +
            '<i class="fa fa-times"></i></div><div class="property-listing property-2">' +
            '<div class="listing-img-wrapper"><div class="list-single-img">' +
            '<a href=""><img src="" class="img-fluid mx-auto" alt="" /></a></div>' +
            '<span class="property-type">Название</span></div><div class="listing-detail-wrapper pb-0">' +
            '<div class="listing-short-detail"><h4 class="listing-name"><a href="">Название</a>' +
            '<i class="list-status ti-check"></i></h4></div></div><div class="price-features-wrapper">' +
            '<div class="listing-price-fx"><h6 class="listing-card-info-price price-prefix"></h6></div>' +
            '<div class="list-fx-features"></div></div></div>' +
            '</div></div></div>',
          });
           test.geoObjects.add(placemark);
           
      });
  }
    
  },
error: function (request) {
    console.log("ERROR", request);
}
});
})