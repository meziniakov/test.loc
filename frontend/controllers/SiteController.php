<?php

namespace frontend\controllers;

use common\models\Organization;
use Yii;
use yii\web\Controller;
use frontend\models\ContactForm;
use vova07\fileapi\actions\UploadAction as FileAPIUpload;
use common\models\LoginForm;
use yii\web\HttpException;
use common\models\Tag;
use common\models\CompanyCategory;
use common\models\CompanySearch;

/**
 * Class SiteController.
 */
class SiteController extends Controller
{
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
        $listing = Organization::find()->where(['is_home' => 1])->all();
        // var_dump($listing);die;
        return $this->render('index', [
            'listing' => $listing,
            'tags' => Tag::find()->all(),
            'categories' => CompanyCategory::find()->active()->all(),
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
