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
    // public function __construct($city)
    // {
    //   // return $this->city = Yii::$app->city->isCity();
    //   $this->city = $city;
    //   print_r($this->city);die;
    //   // echo $this->city = Yii::$app->city->isCity();
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
    public function actionIndex($city = null)
    {
      if($city == null) {
        Yii::$app->params['city'] == 'global';
        $places = Place::find();
        $listing = $places->where(['is_home' => 1])->with('category', 'imageRico', 'city')->all();

        return $this->render('index', [
          'listing' => $listing,
          'places' => $places,
          'tags' => Tag::find()->all(),
          'categories' => PlaceCategory::find()->active()->all(),
          'cities' => City::find()->published()->orderBy(new Expression('rand()'))->with('placies', 'imageRico')->limit(8)->all(),
        ]);
      } elseif($city = Yii::$app->city->isCity($city)) {
          $this->city = $city;
          $places = Place::find();
          $listing = $places->andWhere(['city_id' => $city->id])->with('category', 'imageRico', 'city')->all();
          
          $this->view->title = 'Город ' . $city->name . ' - краткая история, куда сходить, что посмотреть с фотографиями и адресами на trip2place.com';

          Yii::$app->view->registerLinkTag(['rel' => 'canonical', 'href' => Url::current([], true)], 'canonical');
          Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => isset($city->in_obj_phrase) ? 'Достопримечательности, музеи, цирки, места отдыха и многое другое ' . $city->in_obj_phrase : 'Достопримечательности, музеи, цирки, места отдыха и многое другое',
          ], 'description');
      
          Yii::$app->seo->putFacebookMetaTags([
            'og:locale'     => 'ru_RU',
            'og:url'        => Url::current([], true),
            'og:type'       => 'article',
            'og:title'      => isset($city->in_obj_phrase) ? 'Все достопримечательности ' . $city->in_obj_phrase : Yii::$app->keyStorage->get('frontend.index.title'),
            'og:title'      => isset($city->in_obj_phrase) ? 'Достопримечательности, музеи, цирки, места отдыха и многое другое ' . $city->in_obj_phrase : 'Достопримечательности, музеи, цирки, места отдыха и многое другое',
            'og:image'      => $mainImage = Url::to($city->imageRico->getUrl(), true),
            'og:site_name' => 'trip2place - открывай интересные места России',
            // 'og:updated_time' => date(DATE_ATOM, $city->updated_at),
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
            'cities' => City::find()->where('id != :id', ['id' => $city->id])->published()->orderBy(new Expression('rand()'))->with('placies', 'imageRico')->limit(8)->all(),
          ]);
        } else {
            throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
        }
    }

    public function actionEkskursii()
    {
      $this->view->title = 'Бронируйте экскурсии чтобы узнавать больше о городах и их истории на trip2place.com';

      return $this->render('ekskursii', [
      ]);
    }

    public function actionAvia()
    {
      return $this->render('avia');
    }

    public function actionRailway()
    {
      $places = Place::find();
      $listing = $places->where(['is_home' => 1])->with('category', 'imageRico', 'city')->all();

      return $this->render('poezd', [
        'cities' => City::find()->published()->orderBy(new Expression('rand()'))->with('placies', 'imageRico')->limit(8)->all(),
        'listing' => $listing,
        'places' => $places,
      ]);
    }

    public function actionCity()
    {
      $this->view->title = 'Выберите города, которые бы хотели посетить на trip2place.com';

      $model = City::find()->published()->all();
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
