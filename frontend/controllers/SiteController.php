<?php

namespace frontend\controllers;

use common\models\Place;
use Yii;
use yii\web\Controller;
use frontend\models\ContactForm;
use vova07\fileapi\actions\UploadAction as FileAPIUpload;
use common\models\LoginForm;
use yii\web\HttpException;
use common\models\Tag;
use common\models\PlaceCategory;
use common\models\PlaceSearch;
use common\models\City;
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
    public function actionIndex()
    {
        if ($city = City::find()->where('url = :url', [':url' => Yii::$app->params['city']])->one()) {
            $listing = Place::find()->where(['is_home' => 1])->andWhere(['city_id' => $city->id])->with('category')->all();
        } elseif (Yii::$app->params['city'] == 'global') {
            $listing = Place::find()->where(['is_home' => 1])->with('category')->all();
        } else {
            throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
        }
        return $this->render('index', [
            'city' => $city,
            'listing' => $listing,
            'tags' => Tag::find()->all(),
            'categories' => PlaceCategory::find()->active()->all(),
        ]);
    }

    public function actionFaq()
    {
        return $this->render('faq', [
        ]);
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', Yii::t('frontend', 'Thank you for contacting us. We will respond to you as soon as possible.'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('frontend', 'There was an error sending your message.'));
            }

            return $this->refresh();
        } else {
            return $this->render('contact', ['model' => $model]);
        }
    }
}
