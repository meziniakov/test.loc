<?php

namespace backend\modules\parser\controllers;

use Yii;
use yii\helpers\Url;
use GuzzleHttp\Client;
use backend\modules\parser\models\Parser;
use common\models\Place;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use GuzzleHttp\Exception\ConnectException;
use yii\debug\models\search\Log;
use yii\log\Logger;
use yii\web\UploadedFile;
use backend\modules\parser\models\GenerateReviewForm;

/**
 * ParsingController implements the CRUD actions for Parser model.
 */
class IndexController extends Controller
{
  /**
   * {@inheritdoc}
   */
  public function behaviors()
  {
    return [
      'verbs' => [
        'class' => VerbFilter::class,
        'actions' => [
          'delete' => ['POST'],
        ],
      ],
    ];
  }

  /**
   * Lists all Parser models.
   * @return mixed
   */
  public function actionIndex()
  {
    $dataProvider = new ActiveDataProvider([
      'query' => Parser::find(),
    ]);

    return $this->render('index', [
      'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Displays a single Parser model.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionView($id)
  {
    return $this->render('view', [
      'model' => $this->findModel($id),
    ]);
  }

  /**
   * Creates a new Parser model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate()
  {
    $model = new Parser();

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->id]);
    }

    return $this->render('create', [
      'model' => $model,
    ]);
  }

  /**
   * Updates an existing Parser model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionUpdate($id)
  {
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->id]);
    }

    return $this->render('update', [
      'model' => $model,
    ]);
  }

  /**
   * Deletes an existing Parser model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionDelete($id)
  {
    $this->findModel($id)->delete();

    return $this->redirect(['index']);
  }

  /**
   * Finds the Parser model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Parser the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Parser::findOne($id)) !== null) {
      return $model;
    }

    throw new NotFoundHttpException('The requested page does not exist.');
  }

  public function actionResave()
  {
    $null = Place::find()->where(['slug' => null])->all();
    $i = 0;
    foreach($null as $item) {
      if(!empty($item->text)) {
        $item->save();
        // var_dump($item->title);
        // var_dump(empty($item->text));
        // var_dump($item->getErrors());die;
        $i++;
      }
    }
    echo "Up {$i}";
    die;

  }

  public function actionStart($id)
  {
    $model = $this->findModel($id);
    $productsList = $model->getDocument($model->url, $model->uri, $model->user_agent)->find($model->main_tag);
    $urls = $model->getUrls($productsList, $model);

    foreach ($urls as $url) {
      $document = $model->getDocument($url, $model->uri, $model->user_agent);
      $place = new Place();
      $place->title = $document->find($model->tag_name)->text();
      $place->description = $document->find($model->tag_description)->html();

      //   $place->address = $document->find($model->tag_addres)->text();
      // //   $place[] = $document->find($model->tag_city)->text();
      //   $phones[] = $document->find($model->tag_phone)->text();
      //   foreach ($phones as $phone) {
      //     $place->phone = trim($phone);
      //   }
      //   $links[] = $document->find($model->tag_links)->attr('href');
      //   foreach ($links as $link) {
      //     $place[] = $link . "<br>";
      //   }
      //   $place[] = $document->find('script:contains("geocoord:[")')->text();


      //   $place[] = empty($model->uri) ? $document->find($model->tag_image)->attr($model->tag_attr_image) : $model->uri . $document->find($model->tag_image)->attr($model->tag_attr_image);

      // $region = trim($document->find(Yii::$app->params['region'])->text());
      // $city = 
      // $street = trim($document->find(Yii::$app->params['street'])->text());
      // $image = pq($elem)->find('.slider-for')->find('img')->attr(Yii::$app->params['attr-image']);
      //   $categoryList = $document->find('.category-list');
      // print_r($categoryList);die;

      //   $tags = [];
      //   foreach ($categoryList as $tag) {
      //     $tags[] =trim(str_replace("\n", "", pq($tag)->find('.title')->text()));
      //     unset($tags[0]);
      //     // print_r($categoryes);die;
      //   }

      if (!Place::find()->where(['title' => $place->title])->one()) {
        // $place->addTagValues($tags);
        $place->save();
        // return $this->redirect(['view', 'id' => $model->id]);
        // return $this->render('update', [
        //     'model' => $model,
        //     'place' => $place,
        //     ]);
        // echo "Saved";
      } else {
        $place = Place::find()->where(['title' => $place->title])->one();
        // $place->addTagValues($tags);
        $place->imageFile = UploadedFile::getInstance($model, 'imageFile');
        if ($place->imageFile) {
          $place->uploadMainImage();
        }
        $place->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
        $place->uploadGallery();
        $place->update();
        // return $this->redirect(['view', 'id' => $model->id]);
        // return $this->render('update', [
        //     'model' => $model,
        //     'place' => $place,
        //     ]);
        // echo "update";
      }
    }
    if ($place->update()) {
      return $this->redirect(['view', 'id' => $model->id]);
    }
    return $this->refresh();
    Yii::$app->session->setFlash('success', "успешно обновлено");
  }

  public function actionPusk($id)
  {
    setlocale(LC_ALL, 'ru_RU.utf8');
    $parser = $this->findModel($id);

    $parser->getPageByLinkFromXml('https://turizmrm.ru/sitemap.xml');

    Yii::$app->session->setFlash('success', "успешно сохранено");
    return $this->redirect(['index']);
  }

  public function actionTest($id)
  {
    $parser = $this->findModel($id);
    $array = $parser->getDocument($parser->url)->find($parser->main_tag);
    $urls = $parser->getUrls($array, $parser);
    // var_dump($urls);die;

    if (empty($parser->tag_name)) {
      var_dump($urls);
      die;
    }

    $place = [];
    foreach ($urls as $url) {
      $place = new Place();
      $document = $parser->getDocument($url);
      var_dump($document);
      die;
      $place['title'] = $document->find($parser->tag_name)->text();
      $addres = explode(",", substr($document->find('div.transport-brief > p:eq(0)')->text(), 12));
      $document->find('.transport-brief')->remove();
      $document->find('.room-3d-popup')->remove();
      $document->find('.transport-link')->remove();
      $place['text'] = str_replace("\n", "", trim($document->find($parser->tag_description)->text()));
      // $entry = $document->find('head meta[name="keywords"]');
      // // $place['keywords'] = pq($entry)->attr('content');
      $entry = $document->find('head meta[name="description"]');
      $place['description'] = pq($entry)->attr('content');
      $place['images'] = [];
      $entry = $document->find($parser->tag_image);
      foreach ($entry as $row) {
        $place['images'][] = $parser->uri . pq($row)->attr($parser->tag_attr_image);
      }
      $place['breadcrumbs'] = [];
      $entry = $document->find('.breadcrumbs span a');
      foreach ($entry as $row) {
        $ent = pq($row);
        $title = $ent->text();
        $url = $ent->attr('href');
        $place['breadcrumbs'][$title] = $url;
      }
      // if (empty($addres)) {
      //   $place['addres']['city'] = $addres[0];
      //   $place['addres']['street'] = $addres[1];
      //   $place['addres']['house'] = $addres[2];
      // }
      // echo $place['addres']['city'] . "<br>" . $place['addres']['street'] . "<br>" . $place['addres']['house'] . "<br>" . $place['title']. "\n" . $place['text']. "\n" . $place['keywords']. "\n" . $place['description']. "\n";
      // print_r($place['images']) . "\n";
      // print_r($place['breadcrumbs']);

      //   $categoryList = $document->find('.category-list');
      // //   print_r($place->title);die;
      //   $tags = [];
      //   foreach ($categoryList as $tag) {
      //     $tags[] =trim(str_replace("\n", "", pq($tag)->find('.title')->text()));
      //     unset($tags[0]);
      //   }
      // $place->addTagValues($tags);
    }
    //   echo '<pre>';
    //   var_dump($place);
    //   echo '/<pre>';
    //   die;
    $urls = $parser->getUrls($array, $parser);

    foreach ($urls as $url) {
      $document = $parser->getDocument($url);
      $place->title = trim($document->find($parser->tag_name)->text());
      $place->address = substr($document->find('div.transport-brief > p:eq(0)')->text(), 12);
      $addres = explode(",", substr($document->find('div.transport-brief > p:eq(0)')->text(), 12));
      $place->city = $addres[0];
      $document->find('.transport-brief')->remove();
      $document->find('.room-3d-popup')->remove();
      $document->find('.transport-link')->remove();
      $place->description = str_replace("\n", "", trim($document->find($parser->tag_description)->text()));
      $entry = $document->find($parser->tag_image);
      foreach ($entry as $row) {
        $imageUrl = $parser->uri . pq($row)->attr($parser->tag_attr_image);
        $place->images[] = pathinfo($imageUrl);
        $pathinfo = pathinfo($imageUrl);
        $place->imageFiles[] = $place->download($imageUrl, $pathinfo);
      }
      $imageFiles = $place->images;
      if (Place::find()->where(['title' => $place->title])->one()) {
        $place->save();
        $place->uploadImages($imageFiles);
      } else {
        $place->save();
        $place->uploadImages($imageFiles);
      }
    }
    Yii::$app->session->setFlash('success', "успешно сохранено");
    return $this->redirect(['index']);

    return $this->render('test', [
      'parser' => $parser,
      'place' => $place,
    ]);
  }

  public function actionGenerateReview()
  {
    $model = new GenerateReviewForm();
    if ($model->load(Yii::$app->request->post())) {
      $this->view->title = $model->title;

      Yii::$app->view->registerLinkTag(['rel' => 'canonical', 'href' => Url::current([], true)], 'canonical');
      Yii::$app->view->registerMetaTag([
        'name' => 'description',
        'content' => $model->description,
      ], 'description');
  
      $parse_url = parse_url($model->url);
      $uri = $parse_url['scheme'] . '://' . $parse_url['host'];
      // var_dump($uri);
      // die;
      $array = $this->getDocument($model->url)->find($model->findUrls);
      $urls = $this->getUrls($uri, $array, $model->limitUrls);
      foreach ($urls as $url) {
        $html = file_get_contents($url);
        $doc = \phpQuery::newDocument($html);
        
        $title = pq($doc->find('title'))->text();
        $h1 = pq($doc->find('h1'))->text();
        $keywords = pq($doc->find('head meta[name="keywords"]'))->attr('content');
        $description = pq($doc->find('head meta[name="description"]'))->attr('content');

        $img_path = pathinfo(pq($doc->find('head meta[property="og:image"]'))->attr('content'));
        $img = $model->preSrc . $img_path['basename'];
        
        $image = pq($doc->find('meta[itemprop="image"]'))->attr('content');
        $text = pq($doc->find('head meta[property="og:description"]'))->attr('content');

        $data[] = [
          'title' => $title,
          'h1' => $h1,
          'description' => $description,
          'img' => $img,
          'image' => $image,
          'text' => $text,
        ];
      }
      return $this->render('generate-review', [
        'data' => $data,
        'model' => $model
      ]);
    }
    return $this->render('_form2', [
      'model' => $model
    ]);

    // echo "<pre>";
    // print_r($data);
    // echo "</pre>";
    // die;
  }

  public function getDocument($url) {
    $client = new Client();
    $res = $client->request('GET', $url, [
        'headers' => [
          'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36',
          'Content-type' => 'text/html',
          'Accept' => 'text/html',
        ],
        // 'proxy' => [
        //     'socks5' => '174.76.48.230:4145',
        //     // 'http'  => '89.187.177.97:80', // Use this proxy with "http"
        //     // 'http'  => '172.67.181.40:80', // Use this proxy with "http"
        //     // 'https' => '51.178.49.77:3131', // Use this proxy with "https",
        // ],
        ['http_errors' => false],
        // ['connect_timeout' => 1, 'timeout' => 1],
        // 'debug' => true,
    ]);
    $body = $res->getBody();
    $document = \phpQuery::newDocumentHTML($body);
    return $document;
  }

  public function getUrls($uri, $array, $limit) {
    $i = 0;
    $urls = [];
    foreach ($array as $elem) {
      if ($i < $limit) {
        $urls[] = $uri . pq($elem)->find('a')->attr('href');
      }
      $i++;
    }
    return $urls;
  }

}
