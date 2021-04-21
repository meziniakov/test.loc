<?php

namespace frontend\controllers;

use common\models\Article;
use common\models\City;
use yii\web\NotFoundHttpException;
use common\models\ArticleCategory;
use common\models\PlaceCategory;
use common\models\Tag;
use common\models\Place;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class SitemapController extends Controller
{
  public function actionIndex()
  {
    Yii::$app->cache->delete('sitemap');
    if(!$xml_sitemap = Yii::$app->cache->get('sitemap')) {
      $urls = [];

      if ($city = City::find()->where('url = :url', [':url' => Yii::$app->params['city']])->one()) {
        $places = Place::find()->where(['status' => Place::STATUS_PARSED])->andWhere(['city_id' => $city->id])->with('category', 'city')->all();
      } elseif (Yii::$app->params['city'] == 'global') {
        $places = Place::find()->where(['city_id' => null])->with('category')->all();
      } else {
        throw new NotFoundHttpException(Yii::t('frontend', 'Page not found.'));
      }

      foreach($places as $place) {
        $str = '/place/' . $place->category->slug . '/' . $place->slug;
        $urls[] = [
          'loc' => $str, //isset($subdomain) ? $subdomain : 
          'lastmod' => date(DATE_ATOM, strtotime($place->updated_at)),
          'changefreq' => 'daily',
          'priority' => '1',
        ];
      }

      $articles = Article::find()->published()->all();
      foreach($articles as $article) {
        $urls[] = [
          'loc' => '/article/' . $article->slug,
          'lastmod' => date(DATE_ATOM, strtotime($article->updated_at)),
          'changefreq' => 'daily',
          'priority' => '1'
        ];
      }

      $place_categories = PlaceCategory::find()->active()->all();
      foreach($place_categories as $place_category) {
        $urls[] = [
          'loc' => '/place/' . $place_category->slug,
          'changefreq' => 'weekly',
          'priority' => '0.5'  
        ];
      }

      // $article_categories = ArticleCategory::find()->active()->all();
      // foreach($article_categories as $article_category) {
      //   // $urls[] = [
      //   //   'loc' => $article_category->slug,
      //   //   'changefreq' => 'weekly',
      //   //   'priority' => '0.5'  
      //   // ];
      // }

      $place_tags = Tag::find()->orderBy('id')->all();
      foreach($place_tags as $place_tag) {
        $urls[] = [
          'loc' => '/place/tag/' . $place_tag->slug,
          'changefreq' => 'weekly',
          'priority' => '0.4'  
        ];
      }

      $xml_sitemap = $this->renderPartial('index', [
        'host' => Yii::$app->request->hostInfo, //Yii::$app->request->isSecureConnection ? 'https://' : 'http://'
        'urls' => $urls,
      ]);

      Yii::$app->cache->set('sitemap', $xml_sitemap, 60*60*12);
    }

    Yii::$app->response->format = Response::FORMAT_RAW;
    $headers = Yii::$app->response->headers;
    $headers->add('Content-Type', 'text/xml');

    return $xml_sitemap;
  }
}