<?php

namespace frontend\controllers;

use common\models\PlaceCategory;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use common\models\Place;
use common\models\Tag;
use common\models\City;
use yii\web\NotFoundHttpException;
use SimpleXMLElement;
use Exception;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;

class PlaceController extends Controller
{

  public function behaviors()
  {
    return [
      [
        'class' => 'yii\filters\HttpCache',
        // 'only' => ['index'],
        'lastModified' => function ($action, $params) {
          $q = new \yii\db\Query();
          return $q->from('place')->max('updated_at');
        },
      ],
    ];
  }

  const PAGE_SIZE = 10;

  public function actionTest($city)
  {
    $place = new Place();
    $listing = Place::find()->active()->all();
    $place->cnt = count($listing);

    return $this->render('index', [
      'city' => $city,
      'place' => $place,
      'listing' => $listing,
      'categories' => PlaceCategory::find()->active()->all(),
      'tags' => Tag::find()->all()
    ]);
  }

  public function actionTags()
  {
    $tags = Tag::find()->all();

    return $this->render('tags',
    [
      'tags' => $tags,
    ]);
  }

  public function actionIndex()
  {
    // $query = Place::find()->active()->with('category', 'tags');

    $q = Yii::$app->request->get('q');
    $category_id = Yii::$app->request->get('category_id');
    $city_id = Yii::$app->request->get('city_id');
    $tag_id = Yii::$app->request->get('tag_id');

    // $query = Place::find()->parsed()->with('category');

    if ($city = City::find()->where('url = :url', [':url' => Yii::$app->params['city']])->one()) {
      $query = Place::find()->parsed()->where(['city_id' => $city->id])->with('category');
  } elseif (Yii::$app->params['city'] == 'global') {
      $query = Place::find()->parsed()->with('category');
  } else {
      throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
  }
    $query->andFilterWhere([
      'category_id' => $category_id,
      'city_id' => $city_id,
      'tag_id' => $tag_id,
    ]);
    $query->andFilterWhere(['like', 'title', $q]);

    $dataProvider = Place::getDataProvider($query);

    $models = $dataProvider->getModels();

    Yii::$app->view->registerLinkTag(['rel' => 'canonical', 'href' => Url::canonical()], 'canonical');
    Yii::$app->view->registerMetaTag([
      'name' => 'description',
      'content' => 'Surf-city - изучайте Россию вместе с нами.'
    ], 'description');

    Yii::$app->seo->putFacebookMetaTags([
      'og:locale'     => 'ru_RU',
      'og:url'        => Url::canonical(),
      'og:type'       => 'article',
      'og:title'      => 'Surf-City - открывай интересные места России',
      'og:description' => 'Surf-city - изучайте Россию вместе с нами.',
      // 'og:image'      => Url::to($place->getImage()->getUrl(), true),
      // 'og:image:width' => $place->getImage()->getSizes()['width'],
      // 'og:image:height' => $place->getImage()->getSizes()['height'],
      'og:site_name' => 'Surf-City - открывай интересные места России',
      // 'og:updated_time' => Yii::$app->formatter->asDatetime($place->updated_at, "php:Y-m-dTH:i:s+00:00"),
      // 'og:updated_time' => date(DATE_ATOM, $place->updated_at),
      // 'fb:app_id' => '',
      // 'vk:app_id' => '',
      // 'vk:page_id' => '',
      // 'vk:image' => '',
      // 'fb:app_id'=> '1811670458869631',//для статистики по переходам
    ]);

    //   \Yii::$app->seo->putTwitterMetaTags([
    //     'twitter:site'        => Url::canonical(),
    //     'twitter:title'       => $place->title,
    //     'twitter:description' => $place->description,
    //     'twitter:site'     => '@surf-city',
    //     'twitter:creator'     => '@surf-city',
    //     'twitter:image:src'      => Url::to($place->getImage()->getUrl(), true),
    //     'twitter:card'=> 'summary_large_image',
    // ]);

    return $this->render('index', [
        'dataProvider' => $dataProvider,
        'addressInJson' => Place::getJsonForMap($models),
        'categories' => PlaceCategory::find()->active()->asArray()->all(),
        'cities' => City::find()->all(),
        'tags' => Tag::find()->asArray()->all()
      ]
    );
  }

  public function actionSearch()
  {
    $q = Yii::$app->request->get('q');
    $category_id = Yii::$app->request->get('category_id');
    $city_id = Yii::$app->request->get('city_id');
    $tag_id = Yii::$app->request->get('tag_id');

    $query = Place::find()->parsed();
    $query->andFilterWhere([
      'category_id' => $category_id,
      'city_id' => $city_id,
      'tag_id' => $tag_id,
    ]);
    $query->andFilterWhere(['like', 'title', $q])
          ->andFilterWhere(['like', 'text', $q]);

    $dataProvider = Place::getDataProvider($query);

    $models = $dataProvider->getModels();

    return $this->render(
      'search',
      [
        'dataProvider' => $dataProvider,
        'addressInJson' => Place::getJsonForMap($models),
        'categories' => PlaceCategory::find()->active()->all(),
        'cities' => City::find()->all(),
        'tags' => Tag::find()->all()
      ]
    );
  }

  public function actionView($slug)
  {

    $place = $this->findModel($slug);

    Yii::$app->view->registerLinkTag(['rel' => 'canonical', 'href' => Url::canonical()], 'canonical');
    Yii::$app->view->registerMetaTag([
      'name' => 'description',
      'content' => $place->description
    ], 'description');

    Yii::$app->seo->putFacebookMetaTags([
      'og:locale'     => 'ru_RU',
      'og:url'        => Url::canonical(),
      'og:type'       => 'article',
      'og:title'      => $place->title,
      'og:description' => $place->description,
      'og:image'      => Url::to($place->getImage()->getUrl(), true),
      'og:image:width' => $place->getImage()->getSizes()['width'],
      'og:image:height' => $place->getImage()->getSizes()['height'],
      'og:site_name' => 'Surf-City - открывай интересные места России',
      // 'og:updated_time' => Yii::$app->formatter->asDatetime($place->updated_at, "php:Y-m-dTH:i:s+00:00"),
      'og:updated_time' => date(DATE_ATOM, $place->updated_at),
      // 'fb:app_id' => '',
      // 'vk:app_id' => '',
      // 'vk:page_id' => '',
      // 'vk:image' => '',
      // 'fb:app_id'=> '1811670458869631',//для статистики по переходам
    ]);

    //   \Yii::$app->seo->putTwitterMetaTags([
    //     'twitter:site'        => Url::canonical(),
    //     'twitter:title'       => $place->title,
    //     'twitter:description' => $place->description,
    //     'twitter:site'     => '@surf-city',
    //     'twitter:creator'     => '@surf-city',
    //     'twitter:image:src'      => Url::to($place->getImage()->getUrl(), true),
    //     'twitter:card'=> 'summary_large_image',
    // ]);

    return $this->render('view', [
      'place' => $place,
      'addressInJson' => Place::getJsonForMap($place),
    ]);
  }

  public function findModel($slug)
  {
    if (($model = Place::find()->where(['slug' => $slug])->orWhere(['id' => $slug])->with('category', 'tags')->one()) !== null) {
      return $model;
    }
    throw new NotFoundHttpException('Страницы не существует');
  }

  public function actionCategory($slug)
  {
    // $listing = Place::find()->active()->limit(30)->all();
    $model = PlaceCategory::find()->where(['slug' => $slug])->one();
    if (!$model) {
      throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
    }

    $query = Place::find()->with('tags')->joinWith('category')->where('{{%place_category}}.slug = :slug', [':slug' => $slug]);

    $dataProvider = Place::getDataProvider($query);

    $models = $dataProvider->getModels();

    return $this->render('category', [
      'model' => $model,
      'dataProvider' => $dataProvider,
      'addressInJson' => Place::getJsonForMap($models),
      'categories' => PlaceCategory::find()->active()->asArray()->all(),
      'tags' => Tag::find()->asArray()->all()
    ]);
  }

  // public function actionCategory($slug)
  // {
  //   $place = $this->findModel($slug);

  //   return $this->render('view', [
  //     'place' => $place,
  //     'addressInJson' => Place::getJsonForMap($place),
  //   ]);

  // }

  public function actionTag($slug)
  {
    $model = Tag::find()->where(['slug' => $slug])->one();
    if (!$model) {
      throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
    }

    // $listing = Place::find()->with('category')->joinWith('tags')->where('{{%tag}}.slug = :slug', [':slug' => $slug])->all();
    $query = Place::find()->with('category')->joinWith('tags')->where('{{%tag}}.slug = :slug', [':slug' => $slug]);
    $dataProvider = Place::getDataProvider($query);

    $models = $dataProvider->getModels();

    return $this->render('index', [
      'dataProvider' => $dataProvider,
      'categories' => PlaceCategory::find()->active()->asArray()->all(),
      'addressInJson' => Place::getJsonForMap($models),
      'tags' => Tag::find()->asArray()->all()
    ]);
  }

  public function actionJson($slug = null)
  {
    if ($slug == null) {
      $listing = Place::find()->where(['not', ['lat' => null]])->active()->all();
    } else {
      $model = Tag::find()->where(['slug' => $slug])->one();
      if (!$model) {
        throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
      }
      $listing = Place::find()->with('category')->joinWith('tags')->where('{{%tag}}.slug = :slug', [':slug' => $slug])->all();
    }

    Yii::$app->response->format = Response::FORMAT_JSON;

    foreach ($listing as $item) {
      // Отправляем запрос к геокодеру
      if (!$geocode = @file_get_contents('https://geocode-maps.yandex.ru/1.x/?apikey=23968611-fd0e-4aea-9982-22f92e32a9bf&geocode=' . urlencode($item->address))) {
        $error = error_get_last();
        throw new Exception('HTTP request failed. Error: ' . $error['message']);
      }

      $xml = new SimpleXMLElement($geocode);

      $xml->registerXPathNamespace('ymaps', 'http://maps.yandex.ru/ymaps/1.x');
      $xml->registerXPathNamespace('gml', 'http://www.opengis.net/gml');

      $result = $xml->xpath('/ymaps:ymaps/ymaps:GeoObjectCollection/gml:featureMember/ymaps:GeoObject/gml:Point/gml:pos');

      if (isset($result[0])) {

        list($longitude, $latitude) = explode(' ', $result[0]);

        echo $latitude; // Широта
        echo $longitude; // Долгота
      }


      $json[] = [
        'type' => 'Feature',
        'id' => $item->id,
        'geometry' => [
          'type' => 'Point',
          'coordinates' => [$item->lat, $item->lng]
        ],
        'properties' => [
          'balloonContentBody' =>
          '<div class="map-popup-wrap">' .
            '<div class="map-popup"><div class="infoBox-close">' .
            '<i class="fa fa-times"></i></div><div class="property-listing property-2">' .
            '<div class="listing-img-wrapper"><div class="list-single-img">' .
            '<a href=""><img src="/reveal/img/f389baedd25b0b8e84ba403877d6ebdf.jpg" class="img-fluid mx-auto" alt="" /></a></div>' .
            '<span class="property-type">' . $item->type . '</span></div><div class="listing-detail-wrapper pb-0">' .
            '<div class="listing-short-detail"><h4 class="listing-name"><a href="">' . $item->title . '</a>' .
            '<i class="list-status ti-check"></i></h4></div></div><div class="price-features-wrapper">' .
            '<div class="listing-price-fx"><h6 class="listing-card-info-price price-prefix"></h6></div>' .
            '<div class="list-fx-features"></div></div></div>' .
            '</div></div></div>',
          'clusterCaption' => "<strong>" . $item->title . "</strong>",
        ],
      ];
    }

    $results = [
      'type' => 'FeatureCollection',
      'features' => $json
    ];

    return $results;
  }

  public function actionAddress($slug = null)
  {
    Yii::$app->response->format = Response::FORMAT_JSON;

    if ($slug == null) {
      $listing = Place::find()->where(['not', ['address' => null]])->active()->all();
    } else {
      $model = Tag::find()->where(['slug' => $slug])->one();
      if (!$model) {
        throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
      }
      $listing = Place::find()->with('category')->joinWith('tags')->where('{{%tag}}.slug = :slug', [':slug' => $slug])->limit(30)->all();
    }

    $json = [];
    foreach ($listing as $item) {
      if (!empty($item->address)) {
        // print_r($item);
        $json[] = $item->address;
      }
    }
    // return $json;
  }
}
