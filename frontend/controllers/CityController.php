<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use vova07\fileapi\actions\UploadAction as FileAPIUpload;
use common\models\Place;
use common\models\Tag;
use common\models\PlaceCategory;
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
    //     parent::init();

    //     // $uri = explode(".", Yii::$app->request->serverName);
    //     var_dump(Yii::$app->params['city']);
    //     // echo "Hi";
    //     // return $this->city = $city;
    // }
    // public function __construct($city)
    // {
    //     echo $this->city = $city;
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
    public function actionDostoprimechatelnosti()
    {
      if ($city = Yii::$app->city->isCity()) {
        $query = Place::find()->published()->where(['city_id' => $city->id])->with('category', 'city' ,'imageRico');
      } elseif (Yii::$app->params['city'] == 'global') {
        $query = Place::find()->published()->with('category', 'city' ,'imageRico');
      } else {
        throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
      }
  
      $dataProvider = Place::getDataProvider($query);
  
      $models = $dataProvider->getModels();
      
            Yii::$app->view->registerLinkTag(['rel' => 'canonical', 'href' => Url::canonical()], 'canonical');
            Yii::$app->view->registerMetaTag([
              'name' => 'description',
              'content' => isset($city->name) ? 'Достопримечательности, музеи, цирки, места отдыха и многое другое в городе ' . $city->name : 'Достопримечательности, музеи, цирки, места отдыха и многое другое',
            ], 'description');
        
            Yii::$app->seo->putFacebookMetaTags([
              'og:locale'     => 'ru_RU',
              'og:url'        => Url::canonical(),
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
         
            return $this->render('dostoprimechatelnosti', [
              'city' => $city,
              'dataProvider' => $dataProvider,
              'tags' => Tag::find()->all(),
              'categories' => PlaceCategory::find()->active()->all(),
            ]);
    }

    public function actionEvents()
    {
      if ($city = Yii::$app->city->isCity()) {
        $query = Event::find()->published()->where(['city_id' => $city->id])->with('category', 'city' ,'imageRico');
      } elseif (Yii::$app->params['city'] == 'global') {
        $query = Event::find()->published()->with('category', 'city' ,'imageRico');
      } else {
        throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
      }
  
      $dataProvider = Event::getDataProvider($query);
  
      $models = $dataProvider->getModels();
      
            Yii::$app->view->registerLinkTag(['rel' => 'canonical', 'href' => Url::canonical()], 'canonical');
            Yii::$app->view->registerMetaTag([
              'name' => 'description',
              'content' => isset($city->name) ? 'Достопримечательности, музеи, цирки, места отдыха и многое другое в городе ' . $city->name : 'Достопримечательности, музеи, цирки, места отдыха и многое другое',
            ], 'description');
        
            Yii::$app->seo->putFacebookMetaTags([
              'og:locale'     => 'ru_RU',
              'og:url'        => Url::canonical(),
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
         
            return $this->render('dostoprimechatelnosti', [
              'city' => $city,
              'dataProvider' => $dataProvider,
              'tags' => Tag::find()->all(),
              'categories' => PlaceCategory::find()->active()->all(),
            ]);
    }

    public function actionGidy()
    {
      if ($city = Yii::$app->city->isCity()) {
      } elseif (Yii::$app->params['city'] == 'global') {
      } else {
        throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
      }
  
            Yii::$app->view->registerLinkTag(['rel' => 'canonical', 'href' => Url::canonical()], 'canonical');
            Yii::$app->view->registerMetaTag([
              'name' => 'description',
              'content' => isset($city->name) ? 'Достопримечательности, музеи, цирки, места отдыха и многое другое в городе ' . $city->name : 'Достопримечательности, музеи, цирки, места отдыха и многое другое',
            ], 'description');
        
            Yii::$app->seo->putFacebookMetaTags([
              'og:locale'     => 'ru_RU',
              'og:url'        => Url::canonical(),
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
            function connect($url)
            {
              $client = new Client();
              $res = $client->request('GET', $url, [
                'headers' => [
                  // "Authorization: Token 41323de3f24c6a81d6bca4ac1cdf13c4d4089350",
                  // "{'username': 'z2941@ya.ru', 'password': 'G3e9tSFuaR26!2S'}",
                  // 'User-Agent' => $this->user_agent,
                  'Content-type' => 'application/json',
                  // 'Vary' => 'Accept',
                  // 'Accept' => 'text/html',
                ],
                // 'proxy' => [
                //     'socks5' => '174.76.48.230:4145',
                //     // 'http'  => '89.187.177.97:80', // Use this proxy with "http"
                //     // 'http'  => '172.67.181.40:80', // Use this proxy with "http"
                //     // 'https' => '51.178.49.77:3131', // Use this proxy with "https",
                // ],
                ['http_errors' => false],
                ['connect_timeout' => 2, 'timeout' => 5],
                // 'debug' => true,
              ]);
              // echo $res->getStatusCode();die;
              $json = json_decode($res->getBody(), false);
              // var_dump($json);die;
              return $json;
              // echo $body;die;
            }
            $test_url = "https://experience.tripster.ru/api/auth/obtain_token/user/";
            $byCity = "https://experience.tripster.ru/api/experiences/?detailed=true&city__name_ru=" . $city->name;
            $res = connect($byCity);
         

            return $this->render('gidy', [
              'city' => $city,
              'activities' => $res->results,
              // 'listing' => $listing,
              'tags' => Tag::find()->all(),
              'categories' => PlaceCategory::find()->active()->all(),
              'cities' => City::find()->all(),
            ]);

        return $this->render('ekskursii', [
        ]);
    }

}
