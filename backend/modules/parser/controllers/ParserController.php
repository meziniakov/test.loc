<?php

namespace backend\modules\parser\controllers;

use Yii;
use yii\helpers\Url;
use GuzzleHttp\Client;
use backend\modules\parser\models\Parser;
use backend\modules\parser\models\Company;
use common\models\Organization;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use GuzzleHttp\Exception\ConnectException;
use yii\debug\models\search\Log;
use yii\log\Logger;
use yii\web\UploadedFile;
/**
 * ParsingController implements the CRUD actions for Parser model.
 */
class ParserController extends Controller
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

  public function actionStart($id)
  {
    $model = $this->findModel($id);
    $productsList = $model->getDocument($model->url, $model->uri, $model->user_agent)->find($model->main_tag);
    $urls = $model->getUrls($productsList, $model);

    foreach ($urls as $url) {
      $document = $model->getDocument($url, $model->uri, $model->user_agent);
      $company = new Organization();
      $company->name = $document->find($model->tag_name)->text();
      $company->description = $document->find($model->tag_description)->html();

      //   $company->address = $document->find($model->tag_addres)->text();
      // //   $company[] = $document->find($model->tag_city)->text();
      //   $phones[] = $document->find($model->tag_phone)->text();
      //   foreach ($phones as $phone) {
      //     $company->phone = trim($phone);
      //   }
      //   $links[] = $document->find($model->tag_links)->attr('href');
      //   foreach ($links as $link) {
      //     $company[] = $link . "<br>";
      //   }
      //   $company[] = $document->find('script:contains("geocoord:[")')->text();


      //   $company[] = empty($model->uri) ? $document->find($model->tag_image)->attr($model->tag_attr_image) : $model->uri . $document->find($model->tag_image)->attr($model->tag_attr_image);

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

      if (!Organization::find()->where(['name' => $company->name])->one()) {
        // $company->addTagValues($tags);
        $company->save();
        // return $this->redirect(['view', 'id' => $model->id]);
        // return $this->render('update', [
        //     'model' => $model,
        //     'company' => $company,
        //     ]);
        // echo "Saved";
      } else {
        $company = Organization::find()->where(['name' => $company->name])->one();
        // $company->addTagValues($tags);
        $company->imageFile = UploadedFile::getInstance($model, 'imageFile');
        if ($company->imageFile) {
          $company->uploadMainImage();
        }
        $company->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
        $company->uploadGallery();
        $company->update();
        // return $this->redirect(['view', 'id' => $model->id]);
        // return $this->render('update', [
        //     'model' => $model,
        //     'company' => $company,
        //     ]);
        // echo "update";
      }
    }
    if ($company->update()) {
      return $this->redirect(['view', 'id' => $model->id]);
    }
    return $this->refresh();
    Yii::$app->session->setFlash('success', "успешно обновлено");
  }

  public function actionPusk($id)
  {
    setlocale(LC_ALL, 'ru_RU.utf8');
    // echo date(DATE_ATOM);die;
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

    $company = [];
    foreach ($urls as $url) {
      $company = new Organization();
      $document = $parser->getDocument($url);
      var_dump($document);
      die;
      $company['title'] = $document->find($parser->tag_name)->text();
      $addres = explode(",", substr($document->find('div.transport-brief > p:eq(0)')->text(), 12));
      $document->find('.transport-brief')->remove();
      $document->find('.room-3d-popup')->remove();
      $document->find('.transport-link')->remove();
      $company['text'] = str_replace("\n", "", trim($document->find($parser->tag_description)->text()));
      // $entry = $document->find('head meta[name="keywords"]');
      // // $company['keywords'] = pq($entry)->attr('content');
      $entry = $document->find('head meta[name="description"]');
      $company['description'] = pq($entry)->attr('content');
      $company['images'] = [];
      $entry = $document->find($parser->tag_image);
      foreach ($entry as $row) {
        $company['images'][] = $parser->uri . pq($row)->attr($parser->tag_attr_image);
      }
      $company['breadcrumbs'] = [];
      $entry = $document->find('.breadcrumbs span a');
      foreach ($entry as $row) {
        $ent = pq($row);
        $name = $ent->text();
        $url = $ent->attr('href');
        $company['breadcrumbs'][$name] = $url;
      }
      // if (empty($addres)) {
      //   $company['addres']['city'] = $addres[0];
      //   $company['addres']['street'] = $addres[1];
      //   $company['addres']['house'] = $addres[2];
      // }
      // echo $company['addres']['city'] . "<br>" . $company['addres']['street'] . "<br>" . $company['addres']['house'] . "<br>" . $company['title']. "\n" . $company['text']. "\n" . $company['keywords']. "\n" . $company['description']. "\n";
      // print_r($company['images']) . "\n";
      // print_r($company['breadcrumbs']);

      //   $categoryList = $document->find('.category-list');
      // //   print_r($company->name);die;
      //   $tags = [];
      //   foreach ($categoryList as $tag) {
      //     $tags[] =trim(str_replace("\n", "", pq($tag)->find('.title')->text()));
      //     unset($tags[0]);
      //   }
      // $company->addTagValues($tags);
    }
    //   echo '<pre>';
    //   var_dump($company);
    //   echo '/<pre>';
    //   die;
    $urls = $parser->getUrls($array, $parser);

    foreach ($urls as $url) {
      $document = $parser->getDocument($url);
      $company->name = trim($document->find($parser->tag_name)->text());
      $company->address = substr($document->find('div.transport-brief > p:eq(0)')->text(), 12);
      $addres = explode(",", substr($document->find('div.transport-brief > p:eq(0)')->text(), 12));
      $company->city = $addres[0];
      $document->find('.transport-brief')->remove();
      $document->find('.room-3d-popup')->remove();
      $document->find('.transport-link')->remove();
      $company->description = str_replace("\n", "", trim($document->find($parser->tag_description)->text()));
      $entry = $document->find($parser->tag_image);
      foreach ($entry as $row) {
        $imageUrl = $parser->uri . pq($row)->attr($parser->tag_attr_image);
        $company->images[] = pathinfo($imageUrl);
        $pathinfo = pathinfo($imageUrl);
        $company->imageFiles[] = $company->download($imageUrl, $pathinfo);
      }
      $imageFiles = $company->images;
      if (Organization::find()->where(['name' => $company->name])->one()) {
        $company->save();
        $company->uploadImages($imageFiles);
      } else {
        $company->save();
        $company->uploadImages($imageFiles);
      }
    }
    Yii::$app->session->setFlash('success', "успешно сохранено");
    return $this->redirect(['index']);

    return $this->render('test', [
      'parser' => $parser,
      'company' => $company,
    ]);
  }

}
