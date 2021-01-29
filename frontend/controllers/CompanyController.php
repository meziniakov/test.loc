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
use yii\helpers\Json;
use common\models\CompanySearch;

class CompanyController extends Controller
{

  const PAGE_SIZE = 6;

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
    $searchModel = new CompanySearch();
    $dataSearch = $searchModel->search(Yii::$app->request->queryParams);

    $query = Organization::find()->active();
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count()]);
    $listing = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();
    $dataProvider = Organization::getAllPages();
    // $dataJson = json_encode($dataProvider->getModels());
    $models = $dataProvider->getModels();
    $addressInJson = [];
    foreach($models as $row) {
      $img = $row->getImage();
      $addressInJson[] = [
        'addres' => trim($row->address),
        'name' => $row->name,
        'id' => $row->id,
        'mainImg' => $img->getUrl('358x229'),
        'type' => $row->category['title'],
        'lng' => $row->lng,
        'lat' => $row->lat,
      ];
    }
    if (isset($addressInJson) && $addressInJson){
      $addressInJson = Json::encode($addressInJson);
    }
    // $array = $models->getAttributes();
    // $json = Json::encode($models[1]->address);
    // $ids = $dataProvider->getKeys();

    // $models = $dataProvider->getModels();
    // var_dump($addressInJson);die;

    return $this->render('index',
    [
      'dataProvider' => $dataProvider,
      'searchModel' => $searchModel,
      'pages' => $pages,
      'listing' => $listing,
      'models' => $models,
      'addressInJson' => $addressInJson,
      // 'json' => $json,
      'categories' => CompanyCategory::find()->active()->all(),
      'tags' => Tag::find()->all()
    ]
  );
  }

  public function actionSearching()
  {
    $q = Yii::$app->request->get('q');
    $query = Organization::find()->where(['like', 'name', $q]);
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => (int)$countQuery->count()]);
    $listing = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();
    $dataProvider = Organization::getSearchPages($q);
    // $dataJson = json_encode($listing->getModels());
    $models = $dataProvider->getModels();
    $addressInJson = [];
    foreach($models as $row) {
      $img = $row->getImage();
      $addressInJson[] = [
        'addres' => trim($row->address),
        'name' => $row->name,
        'id' => $row->id,
        'mainImg' => $img->getUrl('358x229'),
        'type' => $row->category['title'],
      ];
    }
    $addressInJson = Json::encode($addressInJson);

    // $models = $dataProvider->getModels();

    return $this->render('searching',
    [
      'dataProvider' => $dataProvider,
      // 'searchModel' => $searchModel,
      // 'pages' => $pages,
      'listing' => $listing,
      // 'models' => $models,
      'addressInJson' => $addressInJson,
      'categories' => CompanyCategory::find()->active()->all(),
      'tags' => Tag::find()->all()
    ]
  );
  }

  public function actionSearch()
  {
    $dataProvider = Organization::getSearchPages();
    foreach($dataProvider->getModels() as $row) {
      $img = $row->getImage();
      $addressInJson[] = [
        'addres' => trim($row->address),
        'name' => $row->name,
        'id' => $row->id,
        'mainImg' => $img->getUrl('358x229'),
        'type' => $row->category['title'],
        'lng' => $row->lng,
        'lat' => $row->lat,
      ];
    }
    if (isset($addressInJson) && $addressInJson){
      $addressInJson = Json::encode($addressInJson);
    }
    
    return $this->render('search', [
      'dataProvider' => $dataProvider,
    //   // 'searchModel' => $searchModel,
      // 'pages' => $pages,
      // 'listing' => $listing,
    //   // 'models' => $models,
      'addressInJson' => $addressInJson,
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
        // $listing = Organization::find()->active()->limit(30)->all();
        $searchModel = new CompanySearch();
        $query = Organization::find()->active();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $listing = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        $dataProvider = Organization::getAllPages();
        $models = $dataProvider->getModels();
        $addressInJson = [];
        foreach($models as $row) {
          $img = $row->getImage();
          $addressInJson[] = [
            'addres' => trim($row->address),
            'name' => $row->name,
            'id' => $row->id,
            'mainImg' => $img->getUrl('358x229'),
            'type' => $row->category['title'],
          ];
        }
        $addressInJson = Json::encode($addressInJson);
    
        return $this->render('index',
        [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          'pages' => $pages,
          'listing' => $listing,
          // 'models' => $models,
          'addressInJson' => $addressInJson,
          // 'json' => $json,
          'categories' => CompanyCategory::find()->active()->all(),
          'tags' => Tag::find()->all()
        ]
      );
    


    $model = CompanyCategory::find()->where(['slug' => $slug])->one();
    if (!$model) {
      throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
    }

    $query = Organization::find()->with('tags')->joinWith('category')->where('{{%company_category}}.slug = :slug', [':slug' => $slug]);
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count()]);
    $listing = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();
            // var_dump($query);die;
    $dataProvider = Organization::getAllPages();

    return $this->render('category', [
      'model' => $model,
      'dataProvider' => $dataProvider,
      'pages' => $pages,
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
    
    // $listing = Organization::find()->with('category')->joinWith('tags')->where('{{%tag}}.slug = :slug', [':slug' => $slug])->all();
    $query = Organization::find()->with('category')->joinWith('tags')->where('{{%tag}}.slug = :slug', [':slug' => $slug]);
    $countQuery = clone $query;
    $pages = new Pagination(['totalCount' => $countQuery->count()]);
    $listing = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();
    $dataProvider = Organization::getAllPages();

    return $this->render('index', [
      'dataProvider' => $dataProvider,
      'pages' => $pages,
      'listing' => $listing,
      'categories' => CompanyCategory::find()->active()->all(),
      'tags' => Tag::find()->all()
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