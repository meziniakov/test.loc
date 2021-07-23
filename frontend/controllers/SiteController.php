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
use yii\db\Expression;
use yii\web\NotFoundHttpException;

/**
 * Class SiteController.
 */
class SiteController extends Controller
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
    //   return $this->city = Yii::$app->city->isCity();

    //     // $uri = explode(".", Yii::$app->request->serverName);
    //     // var_dump(Yii::$app->params['city']);
    //     // echo "Hi";
    //     // return $this->city = $city;
    // }
    // public function __construct()
    // {
    //   return $this->city = Yii::$app->city->isCity();
    //   // print_r($this->city);die;
    //   // echo $this->city = Yii::$app->city->isCity();
    //   // // echo $this->city;die;
    //   // var_dump(Yii::$app->params['city']); die;
    //   // var_dump(Yii::$app->city->isCity()); die;
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
    public function actionIndex()
    {
        if ($city = Yii::$app->city->isCity()) {
            $places = Place::find();
            $listing = $places->where(['is_home' => 1])->andWhere(['city_id' => $city->id])->with('category', 'imageRico', 'city')->all();
            
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

            return $this->render('/city/index', [
              'places' => $places,
              'city' => $city,
              'listing' => $listing,
              'tags' => Tag::find()->all(),
              'categories' => PlaceCategory::find()->active()->all(),
              'cities' => City::find()->where('id != :id', ['id' => $city->id])->orderBy(new Expression('rand()'))->with('placies', 'imageRico')->limit(8)->all(),
              ]);
          } elseif (Yii::$app->params['city'] == 'global') {
            $places = Place::find();
            $listing = $places->where(['is_home' => 1])->with('category', 'imageRico', 'city')->all();
        } else {
            throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
        }
    
        return $this->render('index', [
            'listing' => $listing,
            'places' => $places,
            'tags' => Tag::find()->all(),
            'categories' => PlaceCategory::find()->active()->all(),
            'cities' => City::find()->orderBy(new Expression('rand()'))->with('placies', 'imageRico')->limit(8)->all(),
        ]);
    }

    // public function actionFaq()
    // {
    //     return $this->render('faq', [
    //     ]);
    // }

    public function actionEkskursii()
    {
        return $this->render('ekskursii', [
        ]);
    }

    public function actionCity()
    {
      $model = City::find()->all();
      return $this->render('city', [
          'model' => $model,
      ]);
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    // public function actionContact()
    // {
    //     $model = new ContactForm();
    //     if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    //         if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
    //             Yii::$app->session->setFlash('success', Yii::t('frontend', 'Thank you for contacting us. We will respond to you as soon as possible.'));
    //         } else {
    //             Yii::$app->session->setFlash('error', Yii::t('frontend', 'There was an error sending your message.'));
    //         }

    //         return $this->refresh();
    //     } else {
    //         return $this->render('contact', ['model' => $model]);
    //     }
    // }
}
