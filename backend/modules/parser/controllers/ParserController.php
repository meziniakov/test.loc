<?php

namespace backend\modules\parser\controllers;

use Yii;
use yii\helpers\Url;
use GuzzleHttp\Client;
use backend\modules\parser\models\Parser;
use common\models\Organization;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use GuzzleHttp\Exception\ConnectException;
use yii\debug\models\search\Log;
use yii\log\Logger;

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
    // try {
      $client = new Client();
      $res = $client->request('GET', 'https://ivanovo.spravka.city/restorany-kafe-zavedeniya');
      $body = $res->getBody();
      $document = \phpQuery::newDocumentHTML($body);
      $productsList = $document->find($model->main_tag);
    //   $test = pq($productsList)->find('a')->attr('href');
      // var_dump($productsList); die;
      $urls = [];
      $i = 0;
      foreach ($productsList as $elem) {
        if ($i > 0 && $i < $model->total_link) {
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
          $company = new Organization();
          $company->name = $document->find($model->tag_name)->text();
          $company->type = $document->find($model->tag_description)->text();
          // $region = trim($document->find(Yii::$app->params['region'])->text());
          // $city = 
          // $street = trim($document->find(Yii::$app->params['street'])->text());
          $company->description = trim($document->find(Yii::$app->params['description-text'])->text());
          // $image = pq($elem)->find('.slider-for')->find('img')->attr(Yii::$app->params['attr-image']);
          $categoryList = $document->find('.category-list');
          // print_r($categoryList);die;
  
          $tags = [];
          foreach ($categoryList as $tag) {
            $tags[] =trim(str_replace("\n", "", pq($tag)->find('.title')->text()));
            unset($tags[0]);
            // print_r($categoryes);die;
          }
          
          if (!Organization::find()->where(['name' => $company->name])->one()) {
            $company->addTagValues($tags);
            // $company->save();
            echo "Ok";
          } else {
            $company = Organization::find()->where(['name' => $company->name])->one();
            $company->addTagValues($tags);
            // $company->update();
            echo "no";
          }
      }
    }
}