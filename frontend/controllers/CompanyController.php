<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use GuzzleHttp\Client;
use yii\web\Response;
use common\models\Organization;
use common\models\Tag;

class CompanyController extends Controller
{
  public function actionIndex()
  {
    $client = new Client();
    $res = $client->request('GET', Yii::$app->params['url']);

    $body = $res->getBody();
    // var_dump($body);die;
    $document = \phpQuery::newDocumentHTML($body);
    // var_dump($document);die;
    $productsList = $document->find(Yii::$app->params['mainTag']);
    // $test = pq($productsList)->find('a')->attr('href');
    // var_dump($test);die;
    // var_dump($productsList); die;
    // print_r($productsList);die;
    $urls = [];
    $i = 0;
    foreach ($productsList as $elem) {
      if ($i > 0 && $i < 15) {
        $urls[] = pq($elem)->find('a')->attr('href');
      }
      ++$i;
    }
    // var_dump($urls);die;
    foreach ($urls as $url) {
        $client = new Client();
        $res = $client->request('GET', $url);
        $body = $res->getBody();
        $document = \phpQuery::newDocumentHTML($body);
        $model = new Organization();
        $model->name = $document->find(Yii::$app->params['title'])->text();
        $model->type = $document->find(Yii::$app->params['description'])->text();
        // $region = trim($document->find(Yii::$app->params['region'])->text());
        // $city = 
        // $street = trim($document->find(Yii::$app->params['street'])->text());
        $model->description = trim($document->find(Yii::$app->params['description-text'])->text());
        // $image = pq($elem)->find('.slider-for')->find('img')->attr(Yii::$app->params['attr-image']);
        $categoryList = $document->find('.category-list');
        // print_r($categoryList);die;

        $tags = [];
        foreach ($categoryList as $tag) {
          $tags[] =trim(str_replace("\n", "", pq($tag)->find('.title')->text()));
          unset($tags[0]);
          // print_r($categoryes);die;
        }
        

        if (!Organization::find()->where(['name' => $model->name])->one()) {
          $model->addTagValues($tags);
          $model->save();
          echo "Ok";
        } else {
          $model = Organization::find()->where(['name' => $model->name])->one();
          $model->addTagValues($tags);
          $model->update();
          echo "no";
        }
        // print_r($categoryes); die;
        // $sku = pq($elem)->find(Yii::$app->params['sku'])->html();
        // $price = $document->find(Yii::$app->params['price'])->html();
        // Yii::$app->response->format = Response::FORMAT_JSON;
        // $arr[] = [
        //     'title' => $title,
        //     'description' => $description,
        //     'description-text' => $descriptionText,
        //     'region' => $region,
        //     'city' => $city,
        //     'street' => $street,
        //     'categoryes' => $categoryes,
        //     // 'image' => $image,
        //     // 'price' => $price,
        //     // 'sku' => $sku,
        //   ];
    }
    // print_r($arr);
    
die;
    return $this->render('autonews', [
      'body' => $body,
      // 'model' => $model,
      // 'productElem' => $productElem
      //'product' => $product
    ]);
  }

  public function actionForm()
  {
    // $organization = new Organization();
    // $organization->name = "Lubimaya";
    // $post = Organization::findOne(1);
    // $organization->addTagValues('Кафе, Пекарня');
    // $organization->save();
    $model = Organization::find()->anyTagValues('Кафе')->all();
    // var_dump($model);die;
    return $this->render('autonews', [
      // 'body' => $body,
      'model' => $model,
      // 'productElem' => $productElem
      //'product' => $product
    ]);
  }

  public function actionTags()
  {
    $tags = Tag::find()->all();

    return $this->render('tags', 
    [
      'tags' => $tags,
    ]);
  }

  public function actionListing()
  {
    $listing = Organization::find()->all();

    return $this->render('listing', [
      'listing' => $listing,
    ]);
  }
}