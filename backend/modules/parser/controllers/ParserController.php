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
      $productsList = $model->getDocument($model->url)->find($model->main_tag);
      $urls = $model->getUrls($productsList, $model);
      
    //   var_dump($urls);die;

      foreach ($urls as $url) {
          $document = $model->getDocument($url);
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
    }

    public function actionTest($id)
    {
      $model = $this->findModel($id);
      $productsList = $model->getDocument($model->url)->find($model->main_tag);
      $urls = $model->getUrls($productsList, $model);

      if (empty($model->tag_name)) {
      var_dump($urls);die;
      }
      
      $company = [];
      foreach ($urls as $url) {
          $document = $model->getDocument($url);
          $company[] = $document->find($model->tag_name)->text();
          $company[] = $document->find($model->tag_description)->html();
        //   $company[] = $document->find($model->tag_city)->text();
          $company[] = $document->find($model->tag_addres)->text();
        //   $phones[] = $document->find($model->tag_phone)->text();
        //   foreach ($phones as $phone) {
        //     $company[] = trim($phone);
        //   }

        //   $links[] = $document->find($model->tag_links)->attr('href');
        //   foreach ($links as $link) {
        //     $company[] = $link . "<br>";
        //   }
        //   $company[] = $document->find('script:contains("geocoord:[")')->text();

        //   echo $company['name'];die;
        //   $company['description'] = trim($document->find($model->tag_description)->text());
          // $region = trim($document->find(Yii::$app->params['region'])->text());
          // $street = trim($document->find(Yii::$app->params['street'])->text());
          $company[] = empty($model->uri) ? $document->find($model->tag_image)->attr($model->tag_attr_image) : $model->uri . $document->find($model->tag_image)->attr($model->tag_attr_image);

          $categoryList = $document->find('.category-list');
        //   print_r($company->name);die;
          $tags = [];
          foreach ($categoryList as $tag) {
            $tags[] =trim(str_replace("\n", "", pq($tag)->find('.title')->text()));
            unset($tags[0]);
          }
            // $company->addTagValues($tags);
      }
    //   echo '<pre>';
    //   var_dump($company);
    //   echo '/<pre>';
    //   die;
      return $this->render('test', [
        'model' => $model,
        'company' => $company,
        ]);
    }

    // public function getModelSubDir($organization)
    // {
    //     // $organization = Organization::find()
    //     $modelName = $this->getShortClass($model);
    //     $modelDir = $modelName . 's/' . $modelName . $organization->id;

    //     return $modelDir;
    // }
}