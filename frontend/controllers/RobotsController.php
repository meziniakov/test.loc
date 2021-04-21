<?php

namespace frontend\controllers;

use common\models\City;
use yii\web\NotFoundHttpException;
use common\models\Place;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class RobotsController extends Controller
{
  public function actionIndex()
  {
    Yii::$app->cache->delete('robots');
    if(!$robots = Yii::$app->cache->get('robots')) {
      $sitemap = '';

      if ($city = City::find()->where('url = :url', [':url' => Yii::$app->params['city']])->one()) {
        $sitemap = '/sitemap.xml';
      } elseif (Yii::$app->params['city'] == 'global') {
        $sitemap = '/sitemap.xml';
        
      } else {
        throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
      }
      $robots = $this->renderPartial('index', [
        'host' => Yii::$app->request->hostInfo,
        'sitemap' => $sitemap,
      ]);

      Yii::$app->cache->set('robots', $robots, 60*60*12);
    }

    Yii::$app->response->format = Response::FORMAT_RAW;
    $headers = Yii::$app->response->headers;
    $headers->add('Content-Type', 'text/plain');

    return $robots;
  }
}