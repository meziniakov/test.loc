<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use vova07\fileapi\actions\UploadAction as FileAPIUpload;
use common\models\Place;
use common\models\Tag;
use common\models\PlaceCategory;
use common\models\EventCategory;
use common\models\City;
use common\models\Event;
use yii\web\NotFoundHttpException;
use GuzzleHttp\Client;


/**
 * Class SiteController.
 */
class CityController extends Controller
{
    public $city;

    public function behaviors()
    {
      return [
        [
          'class' => 'yii\filters\HttpCache',
          'lastModified' => function ($action, $params) {
            $q = new \yii\db\Query();
            return $q->from(['article'])->max('updated_at');
          },
        ],
      ];
    }  

    // public function init()
    // {
    //   parent::init();
    //   // var_dump(Yii::$app->params['city']);die;
    //   $$this->city = Yii::$app->params['city'];

    //   if ($this->city = Yii::$app->city->isCity($city)) {
    //     $query = Event::find()->published()->where(['city_id' => $city->id])->with('category', 'city' ,'imageRico');
    //   } elseif (Yii::$app->params['city'] == 'global') {
    //     $query = Event::find()->published()->with('category', 'city' ,'imageRico');
    //   } else {
    //     throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
    //   }
    // }
    // public function __construct($city)
    // {
    //     // echo $this->city = $city;
    // }

    // public function beforeAction($action)
    // {
    //     // var_dump($action);die;
    //     // return parent::beforeAction($action);
    // }
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
            ],
            'fileapi-upload' => [
                'class' => FileAPIUpload::class,
                'path' => '@storage/tmp',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionDostoprimechatelnosti($city)
    {
      if ($city = Yii::$app->city->isCity($city)) {
        $query = Place::find()->published()->andWhere(['city_id' => $city->id])->with('category', 'city' ,'imageRico');
      } elseif (Yii::$app->params['city'] == 'global') {
        $query = Place::find()->published()->with('category', 'city' ,'imageRico');
      } else {
        throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
      }

      $this->view->title = 'Культурные места и достопримечательности ' . $city->in_obj_phrase;
  
      $dataProvider = Place::getDataProvider($query);
        
      Yii::$app->view->registerLinkTag(['rel' => 'canonical', 'href' => Url::current([], true)], 'canonical');
      Yii::$app->view->registerMetaTag([
        'name' => 'description',
        'content' => 'Достопримечательности, музеи, цирки, места отдыха и многое другое ' . $city->in_obj_phrase,
      ], 'description');
  
      Yii::$app->seo->putFacebookMetaTags([
        'og:locale'     => 'ru_RU',
        'og:url'        => Url::current([], true),
        'og:type'       => 'article',
        'og:title'      => $this->view->title,
        'og:image'      => Url::to($city->getImage()->getUrl(), true),
        'og:site_name' => 'trip2place - открывай интересные места России',
        // 'og:updated_time' => date(DATE_ATOM, $place->updated_at),
        // 'fb:app_id' => '',
        // 'vk:app_id' => '',
        // 'vk:page_id' => '',
        // 'vk:image' => '',
        // 'fb:app_id'=> '1811670458869631',//для статистики по переходам
      ]);
    
      return $this->render('dostoprimechatelnosti', [
        'city' => $city,
        'dataProvider' => $dataProvider,
        'tags' => Tag::find()->all(),
        'categories' => PlaceCategory::find()->active()->all(),
      ]);
    }

    public function actionEvents($city = null)
    {
      if ($city = Yii::$app->city->isCity($city)) {
        $query = Event::find()->published()->andWhere(['city_id' => $city->id])->with('category', 'city' ,'imageRico');
      } elseif (Yii::$app->params['city'] == 'global') {
        $query = Event::find()->published()->with('category', 'city' ,'imageRico');
      } else {
        throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
      }

      $dataProvider = Event::getDataProvider($query);
      
      $this->view->title = 'События и мероприятия ' . $city->in_obj_phrase;

      Yii::$app->view->registerLinkTag(['rel' => 'canonical', 'href' => Url::current([], true)], 'canonical');
      Yii::$app->view->registerMetaTag([
        'name' => 'description',
        'content' => 'Культурные события, мероприятия и прочий досуг ' . $city->in_obj_phrase,
      ], 'description');
  
      Yii::$app->seo->putFacebookMetaTags([
        'og:locale'     => 'ru_RU',
        'og:url'        => Url::current([], true),
        'og:type'       => 'article',
        'og:title'      => $this->view->title,
        // 'og:image'      => Url::to($place->getImage()->getUrl(), true),
        'og:site_name' => 'trip2place - открывай интересные места России',
        // 'og:updated_time' => date(DATE_ATOM, $place->updated_at),
        // 'fb:app_id' => '',
        // 'vk:app_id' => '',
        // 'vk:page_id' => '',
        // 'vk:image' => '',
        // 'fb:app_id'=> '1811670458869631',//для статистики по переходам
      ]);
    
      return $this->render('events', [
        'city' => $city,
        'dataProvider' => $dataProvider,
        'categories' => EventCategory::find()->active()->all(),
      ]);
    }

    public function actionGidy($city = null)
    {
      if ($city = Yii::$app->city->isCity($city)) {
      } elseif (Yii::$app->params['city'] == 'global') {
      } else {
        throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
      }

      $this->view->title = 'Бронируйте экскурсии ' . $city->in_obj_phrase . ' чтобы поближе познакомиться с городом на trip2place.com';

      Yii::$app->view->registerLinkTag(['rel' => 'canonical', 'href' => Url::current([], true)], 'canonical');
      Yii::$app->view->registerMetaTag([
        'name' => 'description',
        'content' => 'Выбирайте и бронируйте экскурсии от местных жителей ' . $city->in_obj_phrase,
      ], 'description');
  
      Yii::$app->seo->putFacebookMetaTags([
        'og:locale'     => 'ru_RU',
        'og:url'        => Url::current([], true),
        'og:type'       => 'article',
        'og:title'      => $this->view->title,
        // 'og:image'      => Url::to($place->getImage()->getUrl(), true),
        'og:site_name' => 'trip2place - открывай интересные места России',
        // 'og:updated_time' => date(DATE_ATOM, $place->updated_at),
        // 'fb:app_id' => '',
        // 'vk:app_id' => '',
        // 'vk:page_id' => '',
        // 'vk:image' => '',
        // 'fb:app_id'=> '1811670458869631',//для статистики по переходам
      ]);
      function connect($url)
      {
        $client = new Client();
        $res = $client->request('GET', $url, [
          'headers' => [
            'Content-type' => 'application/json',
          ],
        ]);
        $json = json_decode($res->getBody(), false);
        return $json;
      }
      $byCity = "https://experience.tripster.ru/api/experiences/?detailed=true&city__name_ru=" . $city->name;
      $res = connect($byCity);
      // echo "<pre>";
      // var_dump(getSchedule(13493)->begin);die;
    
      return $this->render('gidy', [
        'city' => $city,
        'activities' => $res->results,
      ]);

    }

    public function actionPogoda($city = null)
    {
      if ($city = Yii::$app->city->isCity($city)) {
      } elseif (Yii::$app->params['city'] == 'global') {
      } else {
        throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
      }
  
      Yii::$app->view->registerLinkTag(['rel' => 'canonical', 'href' => Url::current([], true)], 'canonical');
      Yii::$app->view->registerMetaTag([
        'name' => 'description',
        'content' => isset($city->name) ? 'Достопримечательности, музеи, цирки, места отдыха и многое другое в городе ' . $city->name : 'Достопримечательности, музеи, цирки, места отдыха и многое другое',
      ], 'description');
  
      Yii::$app->seo->putFacebookMetaTags([
        'og:locale'     => 'ru_RU',
        'og:url'        => Url::current([], true),
        'og:type'       => 'article',
        'og:title'      => isset($city->name) ? 'Все достопримечательности в городе ' . $city->name : Yii::$app->keyStorage->get('frontend.index.title'),
        'og:title'      => isset($city->name) ? 'Достопримечательности, музеи, цирки, места отдыха и многое другое в городе ' . $city->name : 'Достопримечательности, музеи, цирки, места отдыха и многое другое',
        // 'og:image'      => Url::to($place->getImage()->getUrl(), true),
        // 'og:image:width' => $place->getImage()->getSizes()['width'],
        // 'og:image:height' => $place->getImage()->getSizes()['height'],
        'og:site_name' => 'trip2place - открывай интересные места России',
        // 'og:updated_time' => Yii::$app->formatter->asDatetime($place->updated_at, "php:Y-m-dTH:i:s+00:00"),
        // 'og:updated_time' => date(DATE_ATOM, $place->updated_at),
        // 'fb:app_id' => '',
        // 'vk:app_id' => '',
        // 'vk:page_id' => '',
        // 'vk:image' => '',
        // 'fb:app_id'=> '1811670458869631',//для статистики по переходам
      ]);
      function connectClient($url, $city)
      {
        $client = new Client();
        $res = $client->get($url, [
          // 'headers' => [
          //   // "Authorization: Token 41323de3f24c6a81d6bca4ac1cdf13c4d4089350",
          //   // "{'username': 'z2941@ya.ru', 'password': 'G3e9tSFuaR26!2S'}",
          //   // 'User-Agent' => $this->user_agent,
          //   // 'Content-type' => 'application/json',
          //   // 'Vary' => 'Accept',
          //   // 'Accept' => 'text/html',
          // ],
          'query' => [
            'q' => $city,
            'cnt' => 6,
            'units' => 'metric',
            'lang' => 'ru',
            'appid' => '6eea4815462a3754eda2f48540473bc5',
          ],
          // 'proxy' => [
          //     'socks5' => '174.76.48.230:4145',
          //     // 'http'  => '89.187.177.97:80', // Use this proxy with "http"
          //     // 'http'  => '172.67.181.40:80', // Use this proxy with "http"
          //     // 'https' => '51.178.49.77:3131', // Use this proxy with "https",
          // ],
          // ['http_errors' => false],
          // ['connect_timeout' => 2, 'timeout' => 5],
          // 'debug' => true,
        ]);
        $json = json_decode($res->getBody(), true);
        // $json = json_encode($json);
        // $json = $res->getBody()->getContents();
        // $json = $res->getBody();
        // echo "<pre>";
        // var_dump($json['list'][0]['wind']['speed']);die;
        return $json;
        // echo $body;die;
      }
      $byCity = "https://api.openweathermap.org/data/2.5/forecast";
      $current = "https://api.openweathermap.org/data/2.5/weather";
      $res = connectClient($byCity, $city->name);
      $current = connectClient($current, $city->name);
      // echo json_encode($res['cnt']);die;
    
      return $this->render('pogoda', [
        'city' => $city,
        'current' => $current,
        // 'activities' => $res->results,
        // 'listing' => $listing,
        'tags' => Tag::find()->all(),
        'categories' => PlaceCategory::find()->active()->all(),
        'cities' => City::find()->published()->all(),
      ]);
    }
}
