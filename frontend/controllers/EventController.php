<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use common\models\Event;
use common\models\Tag;
use common\models\City;
use common\models\EventCategory;
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

  public $city;

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

  public function actionIndex($city = null)
  {
    $q = Yii::$app->request->get('q');
    $category_id = Yii::$app->request->get('category_id');
    $city_id = Yii::$app->request->get('city_id');
    $tag_id = Yii::$app->request->get('tag_id');

    if ($city = Yii::$app->city->isCity($city)) {
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
      // 'og:image'      => Url::to($event->getImage()->getUrl(), true),
      // 'og:image:width' => $event->getImage()->getSizes()['width'],
      // 'og:image:height' => $event->getImage()->getSizes()['height'],
      'og:site_name' => 'Surf-City - открывай интересные места России',
      // 'og:updated_time' => Yii::$app->formatter->asDatetime($event->updated_at, "php:Y-m-dTH:i:s+00:00"),
      // 'og:updated_time' => date(DATE_ATOM, $event->updated_at),
      // 'fb:app_id' => '',
      // 'vk:app_id' => '',
      // 'vk:page_id' => '',
      // 'vk:image' => '',
      // 'fb:app_id'=> '1811670458869631',//для статистики по переходам
    ]);

    //   \Yii::$app->seo->putTwitterMetaTags([
    //     'twitter:site'        => Url::canonical(),
    //     'twitter:title'       => $event->title,
    //     'twitter:description' => $event->description,
    //     'twitter:site'     => '@trip2event',
    //     'twitter:creator'     => '@trip2event',
    //     'twitter:image:src'      => Url::to($event->getImage()->getUrl(), true),
    //     'twitter:card'=> 'summary_large_image',
    // ]);

    return $this->render(
      'index',
      [
        'dataProvider' => $dataProvider,
        // 'addressInJson' => Event::getJsonForMap($models),
        'categories' => EventCategory::find()->active()->asArray()->all(),
        'cities' => City::find()->published()->all(),
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

    $query = Event::find()->parsed();
    $query->andFilterWhere([
      'category_id' => $category_id,
      'city_id' => $city_id,
      'tag_id' => $tag_id,
    ]);
    $query->andFilterWhere(['like', 'title', $q])
      ->andFilterWhere(['like', 'text', $q]);

    $dataProvider = Event::getDataProvider($query);

    $models = $dataProvider->getModels();

    return $this->render(
      'search',
      [
        'dataProvider' => $dataProvider,
        'addressInJson' => Event::getJsonForMap($models),
        'categories' => EventCategory::find()->active()->all(),
        'cities' => City::find()->published()->all(),
        'tags' => Tag::find()->all()
      ]
    );
  }

  public function actionView($slug, $city = null)
  {
    if ($city = Yii::$app->city->isCity($city)) {
      $event = $this->findModel($slug, $city->id);
      $otherEvent = Event::find()->parsed()->where(['!=', 'id', $event->id])->andWhere(['category_id' => $event->category_id])->andWhere(['city_id' => $city->id])->limit(5)->all();
    } elseif (Yii::$app->params['city'] == 'global') {
      $event = $this->findModel($slug);
      $otherEvent = Event::find()->parsed()->where(['!=', 'id', $event->id])->with('category')->limit(5)->all();
    } else {
      throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
    }

    Yii::$app->view->registerLinkTag(['rel' => 'canonical', 'href' => Url::canonical()], 'canonical');
    Yii::$app->view->registerMetaTag([
      'name' => 'description',
      // 'content' => $event->city ? $event->title . " $event->address в городе {$event->city->name} - описание, все фотографии, местоположение на Surf-city.ru. Контакты" : $event->title . " $event->address - описание, все фотографии, местоположение на Surf-city.ru. Контакты",
    ], 'description');

    Yii::$app->seo->putFacebookMetaTags([
      'og:locale'     => 'ru_RU',
      'og:url'        => Url::canonical(),
      'og:type'       => 'article',
      'og:title'      => $event->title,
      // 'og:description' => $event->city ? $event->title . " $event->address в городе {$event->city->name} - описание, все фотографии, местоположение на Surf-city.ru. Контакты" : $event->title . " $event->address - описание, все фотографии, местоположение на Surf-city.ru. Контакты",
      'og:image'      => Url::to($event->getImage()->getUrl(), true),
      'og:image:width' => $event->getImage()->getSizes()['width'],
      'og:image:height' => $event->getImage()->getSizes()['height'],
      'og:site_name' => 'Surf-City - открывай интересные места России',
      // 'og:updated_time' => Yii::$app->formatter->asDatetime($event->updated_at, "php:Y-m-dTH:i:s+00:00"),
      'og:updated_time' => date(DATE_ATOM, $event->updated_at),
      // 'fb:app_id' => '',
      // 'vk:app_id' => '',
      // 'vk:page_id' => '',
      // 'vk:image' => '',
      // 'fb:app_id'=> '1811670458869631',//для статистики по переходам
    ]);

    //   \Yii::$app->seo->putTwitterMetaTags([
    //     'twitter:site'        => Url::canonical(),
    //     'twitter:title'       => $event->title,
    //     'twitter:description' => $event->description,
    //     'twitter:site'     => '@trip2event',
    //     'twitter:creator'     => '@trip2event',
    //     'twitter:image:src'      => Url::to($event->getImage()->getUrl(), true),
    //     'twitter:card'=> 'summary_large_image',
    // ]);

    $image = $event->getImage();
    $img = Yii::$app->request->hostInfo . $image->getUrl();
    // $phone = '+'.$event->phone[0]['phones'];
    
    // $schema = Json::encode([
    //   "@context" => "http://schema.org",
    //   "@type" => "LocalBusiness",
    //   "name" => $event->title,
    //   "image" => $img,
    //   "telephone" => $phone,
    //   "email" => "",
    //   "address" => [
    //     "@type" => "PostalAddress",
    //     "streetAddress" => $event->address
    //     ]
    //   ]);
      
    return $this->render('view', [
      'event' => $event,
      'otherEvent' => $otherEvent,
      // 'schema' => $schema,
      // 'addressInJson' => Event::getJsonForMap($event),
    ]);
  }

  public function findModel($slug, $city_id = null)
  {
    if (($model = Event::find()->where(['slug' => $slug])->andWhere(['city_id' => $city_id])->with('category', 'tags')->one()) !== null) {
      return $model;
    }
    throw new NotFoundHttpException('Страницы не существует');
  }

  public function findModelCategory($slug, $city_id = null)
  {
    $model = Event::find()->joinWith(['category'])->where('{{%event_category}}.slug = :slug', [':slug' => $slug])->andWhere(['city_id' => $city_id]);
    if($model->one() !== null) {
      return $model;
    } else {
      $model = Event::find()->joinWith(['category'])->where('{{%event_category}}.slug = :slug', [':slug' => $slug]);
      if ($model->one() !== null) {
        return $model;
      }
    }
    throw new NotFoundHttpException('Страницы не существует');
  }

  public function actionCategory($slug, $city = null)
  {
    if ($city = Yii::$app->city->isCity($city)) {
      $query = $this->findModelCategory($slug, $city->id);
      $event = $query->one();
    } elseif (Yii::$app->params['city'] == 'global') {
      $query = $this->findModelCategory($slug);
      $event = $query->one();
      $dataProvider = Event::getDataProvider($query);

      return $this->render('allcategory', [
        'event' => $event,
        'dataProvider' => $dataProvider,
        // 'addressInJson' => Event::getJsonForMap($models),
        'categories' => EventCategory::find()->active()->asArray()->all(),
        // 'tags' => Tag::find()->asArray()->all()
      ]);
      } else {
      throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
    }

    $dataProvider = Event::getDataProvider($query);

    return $this->render('category', [
      'event' => $event,
      'dataProvider' => $dataProvider,
      // 'addressInJson' => Event::getJsonForMap($models),
      'categories' => EventCategory::find()->active()->asArray()->all(),
      // 'tags' => Tag::find()->asArray()->all()
    ]);
  }

  public function actionTag($slug)
  {
    $model = Tag::find()->where(['slug' => $slug])->one();
    if (!$model) {
      throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
    }
    // $listing = Event::find()->with('category')->joinWith('tags')->where('{{%tag}}.slug = :slug', [':slug' => $slug])->all();
    $query = Event::find()->with('category')->joinWith('tags')->where('{{%tag}}.slug = :slug', [':slug' => $slug]);
    $dataProvider = Event::getDataProvider($query);

    $models = $dataProvider->getModels();

    return $this->render('index', [
      'dataProvider' => $dataProvider,
      'categories' => EventCategory::find()->active()->asArray()->all(),
      'addressInJson' => Event::getJsonForMap($models),
      'tags' => Tag::find()->asArray()->all()
    ]);
  }

}
