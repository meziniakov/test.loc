<?php

namespace frontend\controllers;

use common\models\CompanyCategory;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use common\models\Organization;
use common\models\Tag;
use yii\web\NotFoundHttpException;
use SimpleXMLElement;
use Exception;
use yii\base\Exception as BaseException;
use yii\data\Pagination;

class CompanyController extends Controller
{

  public function actionTest($city)
  {
    $company = new Organization();
    $listing = Organization::find()->active()->all();
    $company->cnt = count($listing);
    
    return $this->render('index', [
      'city' => $city,
      'company' => $company,
      'listing' => $listing,
      'categories' => CompanyCategory::find()->active()->all(),
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
    // $listing = Organization::find()->active()->limit(30)->all();
    $query = Organization::find()->active();
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count()]);
    $listing = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();
    $dataProvider = Organization::getAllPages();

    return $this->render('index',
    [
      'dataProvider' => $dataProvider,
      'pages' => $pages,
      'listing' => $listing,
      'categories' => CompanyCategory::find()->active()->all(),
      'tags' => Tag::find()->all()
    ]
  );
  }

  public function actionView($slug) {

    $company = $this->findModel($slug);
    return $this->render('view', [
      'company' => $company
    ]);
  }

  public function findModel($slug) {
    if (($model = Organization::find()->where(['slug' => $slug])->orWhere(['id' => $slug])->one()) !== null) {
      return $model;
    }
    throw new NotFoundHttpException('Страницы не существует');
  }

  public function actionCategory($slug) {
    $model = CompanyCategory::find()->where(['slug' => $slug])->one();
    if (!$model) {
      throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
    }
    $company = new Organization();
    $listing = Organization::find()->with('tags')->joinWith('category')->where('{{%company_category}}.slug = :slug', [':slug' => $slug])->limit(20)->all();
    $company->cnt = count($listing);

    return $this->render('index', [
      'company' => $company,
      'listing' => $listing,
      'categories' => CompanyCategory::find()->active()->all(),
      'tags' => Tag::find()->all()
    ]);
  }

  public function actionTag($slug) {
    $model = Tag::find()->where(['slug' => $slug])->one();
    if (!$model) {
      throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
    }
    $listing = Organization::find()->with('category')->joinWith('tags')->where('{{%tag}}.slug = :slug', [':slug' => $slug])->all();

    return $this->render('index', [
      'listing' => $listing
    ]);
  }

  public function actionJson($slug = null)
  {
    if ($slug == null) {
      $listing = Organization::find()->where(['not', ['lat' => null]])->active()->all();
    } else {
      $model = Tag::find()->where(['slug' => $slug])->one();
      if (!$model) {
        throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
      }
      $listing = Organization::find()->with('category')->joinWith('tags')->where('{{%tag}}.slug = :slug', [':slug' => $slug])->all();
    }

    Yii::$app->response->format = Response::FORMAT_JSON;

    foreach ($listing as $item) {
      // Отправляем запрос к геокодеру
      if (!$geocode = @file_get_contents( 'https://geocode-maps.yandex.ru/1.x/?apikey=23968611-fd0e-4aea-9982-22f92e32a9bf&geocode=' . urlencode($item->address))) {
        $error = error_get_last();
        throw new Exception( 'HTTP request failed. Error: ' . $error['message'] );
      }
      
      $xml = new SimpleXMLElement($geocode);
      
      $xml->registerXPathNamespace( 'ymaps', 'http://maps.yandex.ru/ymaps/1.x' );
      $xml->registerXPathNamespace( 'gml', 'http://www.opengis.net/gml' );
      
      $result = $xml->xpath( '/ymaps:ymaps/ymaps:GeoObjectCollection/gml:featureMember/ymaps:GeoObject/gml:Point/gml:pos' );
      
      if ( isset( $result[0] ) ) {
      
        list( $longitude, $latitude ) = explode( ' ', $result[0] );
      
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
          '<div class="listing-short-detail"><h4 class="listing-name"><a href="">' . $item->name . '</a>' .
          '<i class="list-status ti-check"></i></h4></div></div><div class="price-features-wrapper">' .
          '<div class="listing-price-fx"><h6 class="listing-card-info-price price-prefix"></h6></div>' .
          '<div class="list-fx-features"></div></div></div>' .
          '</div></div></div>',
          'clusterCaption' => "<strong>" . $item->name . "</strong>",
        ],
      ];
    }

    $results = [
      'type' => 'FeatureCollection',
      'features' => $json ];

      return $results;
  }

  public function actionAddress($slug = null)
  {
    Yii::$app->response->format = Response::FORMAT_JSON;

    if ($slug == null) {
      $listing = Organization::find()->where(['not', ['address' => null]])->active()->all();
    } else {
      $model = Tag::find()->where(['slug' => $slug])->one();
      if (!$model) {
        throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
      }
      $listing = Organization::find()->with('category')->joinWith('tags')->where('{{%tag}}.slug = :slug', [':slug' => $slug])->limit(30)->all();
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