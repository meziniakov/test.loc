<?php

namespace frontend\controllers;

use common\models\PlaceCategory;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use common\models\Event;
use common\models\Place;
use common\models\Tag;
use common\models\City;
use yii\web\NotFoundHttpException;
use SimpleXMLElement;
use Exception;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;

class EventController extends Controller
{

  public function behaviors()
  {
    return [
      [
        'class' => 'yii\filters\HttpCache',
        // 'only' => ['index'],
        'lastModified' => function ($action, $params) {
          $q = new \yii\db\Query();
          return $q->from('event')->max('updated_at');
        },
      ],
    ];
  }

  const PAGE_SIZE = 10;

  public function actionTags()
  {
    $tags = Tag::find()->all();

    return $this->render(
      'tags',
      [
        'tags' => $tags,
      ]
    );
  }

  public function actionIndex()
  {
    $q = Yii::$app->request->get('q');
    $category_id = Yii::$app->request->get('category_id');
    $city_id = Yii::$app->request->get('city_id');
    $tag_id = Yii::$app->request->get('tag_id');

    if ($city = City::find()->where('url = :url', [':url' => Yii::$app->params['city']])->one()) {
      $query = Event::find()->where(['city_id' => $city->id])->with('category');
    } elseif (Yii::$app->params['city'] == 'global') {
      $query = Event::find()->with('category');
    } else {
      throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
    }
    $query->andFilterWhere([
      'category_id' => $category_id,
      'city_id' => $city_id,
      'tag_id' => $tag_id,
    ]);
    $query->andFilterWhere(['like', 'title', $q]);

    $dataProvider = Event::getDataProvider($query);

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
    //     'twitter:site'     => '@trip2place',
    //     'twitter:creator'     => '@trip2place',
    //     'twitter:image:src'      => Url::to($place->getImage()->getUrl(), true),
    //     'twitter:card'=> 'summary_large_image',
    // ]);

    return $this->render(
      'index',
      [
        'dataProvider' => $dataProvider,
        'addressInJson' => Event::getJsonForMap($models),
        // 'categories' => PlaceCategory::find()->active()->asArray()->all(),
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
    if ($city = City::find()->where('url = :url', [':url' => Yii::$app->params['city']])->one()) {
      $place = $this->findModel($slug, $city->id);
      $otherPlace = Place::find()->parsed()->where(['!=', 'id', $place->id])->andWhere(['category_id' => $place->category_id])->andWhere(['city_id' => $city->id])->limit(5)->all();
    } elseif (Yii::$app->params['city'] == 'global') {
      $place = $this->findModel($slug);
      $otherPlace = Place::find()->parsed()->where(['!=', 'id', $place->id])->with('category')->limit(5)->all();
    } else {
      throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
    }

    Yii::$app->view->registerLinkTag(['rel' => 'canonical', 'href' => Url::canonical()], 'canonical');
    Yii::$app->view->registerMetaTag([
      'name' => 'description',
      'content' => $place->city ? $place->title . " $place->address в городе {$place->city->name} - описание, все фотографии, местоположение на Surf-city.ru. Контакты" : $place->title . " $place->address - описание, все фотографии, местоположение на Surf-city.ru. Контакты",
    ], 'description');

    Yii::$app->seo->putFacebookMetaTags([
      'og:locale'     => 'ru_RU',
      'og:url'        => Url::canonical(),
      'og:type'       => 'article',
      'og:title'      => $place->title,
      'og:description' => $place->city ? $place->title . " $place->address в городе {$place->city->name} - описание, все фотографии, местоположение на Surf-city.ru. Контакты" : $place->title . " $place->address - описание, все фотографии, местоположение на Surf-city.ru. Контакты",
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
    //     'twitter:site'     => '@trip2place',
    //     'twitter:creator'     => '@trip2place',
    //     'twitter:image:src'      => Url::to($place->getImage()->getUrl(), true),
    //     'twitter:card'=> 'summary_large_image',
    // ]);

    $image = $place->getImage();
    $img = Yii::$app->request->hostInfo . $image->getUrl();
    $phone = '+'.$place->phone[0]['phones'];
    
    $schema = Json::encode([
      "@context" => "http://schema.org",
      "@type" => "LocalBusiness",
      "name" => $place->title,
      "image" => $img,
      "telephone" => $phone,
      "email" => "",
      "address" => [
        "@type" => "PostalAddress",
        "streetAddress" => $place->address
        ]
      ]);
      
    return $this->render('view', [
      'place' => $place,
      'otherPlace' => $otherPlace,
      'schema' => $schema,
      'addressInJson' => Place::getJsonForMap($place),
    ]);
  }

  public function findModel($slug, $city_id = null)
  {
    if (($model = Place::find()->where(['slug' => $slug])->andWhere(['city_id' => $city_id])->with('category', 'tags')->one()) !== null) {
      return $model;
    }
    throw new NotFoundHttpException('Страницы не существует');
  }

  public function findModelCategory($slug, $city_id = null)
  {
    $model = Place::find()->joinWith(['category'])->where('{{%place_category}}.slug = :slug', [':slug' => $slug])->andWhere(['city_id' => $city_id]);
    if ($model->one() !== null) {
      return $model;
    }
    throw new NotFoundHttpException('Страницы не существует');
  }

  public function actionCategory($slug)
  {
    if ($city = City::find()->where('url = :url', [':url' => Yii::$app->params['city']])->one()) {
      $query = $this->findModelCategory($slug, $city->id);
      $place = $query->one();
    } elseif (Yii::$app->params['city'] == 'global') {
      $query = $this->findModelCategory($slug);
      $place = $query->one();
    } else {
      throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
    }

    $dataProvider = Place::getDataProvider($query);

    $models = $dataProvider->getModels();

    return $this->render('category', [
      'place' => $place,
      'dataProvider' => $dataProvider,
      'addressInJson' => Place::getJsonForMap($models),
      // 'categories' => PlaceCategory::find()->active()->asArray()->all(),
      // 'tags' => Tag::find()->asArray()->all()
    ]);
  }

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

}
