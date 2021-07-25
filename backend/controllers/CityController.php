<?php

namespace backend\controllers;

use backend\models\search\CitySearch;
use Yii;
use common\models\City;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use nickdenry\grid\toggle\actions\ToggleAction;

/**
 * CityController implements the CRUD actions for City model.
 */
class CityController extends Controller
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

    public function actions()
    {
        return [
            'switch' => [
                'class' => ToggleAction::class,
                'modelClass' => 'common\models\City', // Your model class
            ],
        ];
    }

    // public function init()
    // {
    //     parent::init();
    //     $this->all = City::find()->count();
    //     $this->trashed = Place::find()->where(['=', 'status', Place::STATUS_TRASHED])->count();
    //     $this->parsed = Place::find()->where(['=', 'status', Place::STATUS_PARSED])->count();
    //     $this->edited = Place::find()->where(['=', 'status', Place::STATUS_EDITED])->count();
    //     $this->published = Place::find()->where(['=', 'status', Place::STATUS_PUBLISHED])->count();
    //     $this->updated = Place::find()->where(['=', 'status', Place::STATUS_UPDATED])->count();
    //     }

    /**
     * Lists all City models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new CitySearch();
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // $dataProvider->sort = [
        //     'defaultOrder' => ['name_en' => SORT_DESC],
        // ];

        // print_r($dataProvider->getKeys());die;

        // $dataProvider = new ActiveDataProvider([
        //     'query' => City::find(),
        //     'pagination' => [
        //         'pageSize' => 100,
        //     ],
        //     'sort' => [
        //         'defaultOrder' => [
        //             'name_en' => SORT_DESC, 
        //         ]
        //     ],        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    /**
     * Displays a single City model.
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
     * Creates a new City model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new City();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->imageFile){
                // $model->frameImage();
                $model->uploadMainImage();
            }
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if ($model->imageFiles){
                $model->uploadGallery();
            }
            Yii::$app->session->setFlash('success', "успешно обновлено");
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing City model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->imageFile){
                // $model->frameImage();
                $model->uploadMainImage();
            }
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if ($model->imageFiles){
                $model->uploadGallery();
            }
            Yii::$app->session->setFlash('success', "успешно обновлено");
            return $this->refresh();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing City model.
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

    public function actionDeletemoreimg($id){

        $place = City::findOne($id);

        $imageId = Yii::$app->request->get('imageId');
        $images = $place->getImages();
        foreach ($images as $image) {
            if ($image->id == $imageId) {
                $place->removeImage($image);
            }
        }
        return $this->redirect(["/city/update", "id" => $id]);
    }

    /**
     * Finds the City model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return City the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = City::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionMultipleChangeStatus()
    {
        var_dump(Yii::$app->request->post('id','status'));die;
        if (Yii::$app->request->post('id','status')) {
            City::updateAll(['status' => Yii::$app->request->post('')], ['id' => Yii::$app->request->post('id')]);
        }
        Yii::$app->session->setFlash('success', 'Успешно изменено');
        return $this->redirect(Yii::$app->request->referrer);
    }

}
