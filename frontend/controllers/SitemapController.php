<?php

namespace frontend\controllers;

use common\models\Article;
use common\models\ArticleCategory;
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

      $places = Place::findAll(['status' => Place::STATUS_PARSED]);
      foreach($places as $place) {
        $urls[] = [
          'loc' => 'place/' . $place->category->slug . '/' . $place->slug, //Yii::$app->request->hostInfo
          'lastmod' => date(DATE_ATOM, strtotime($place->updated_at)),
          'changefreq' => 'daily',
          'priority' => '1'
        ];
      }

      $articles = Article::find()->published()->all();
      foreach($articles as $article) {
        $urls[] = [
          'loc' => $article->slug, //Yii::$app->request->hostInfo
          'lastmod' => date(DATE_ATOM, strtotime($article->updated_at)),
          'changefreq' => 'daily',
          'priority' => '1'
        ];
      }

      $article_categories = ArticleCategory::find()->active()->all();
      foreach($article_categories as $article_category) {
        // $urls[] = [
        //   'loc' => $article_category->slug,
        //   'changefreq' => 'weekly',
        //   'priority' => '0.5'  
        // ];
      }

      $tags = Tag::find()->orderBy('id')->all();
      foreach($tags as $tag) {
        // $urls[] = [
        //   'loc' => $tag->slug,
        //   'changefreq' => 'weekly',
        //   'priority' => '0.4'  
        // ];
      }

      $xml_sitemap = $this->renderPartial('index', [
        'host' => Yii::$app->request->hostInfo,
        'urls' => $urls
      ]);

      Yii::$app->cache->set('sitemap', $xml_sitemap, 60*60*12);
    }

    Yii::$app->response->format = Response::FORMAT_RAW;
    $headers = Yii::$app->response->headers;
    $headers->add('Content-Type', 'text/xml');

    return $xml_sitemap;
  }
}