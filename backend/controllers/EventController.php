<?php

namespace backend\controllers;

use common\models\City;
use Yii;
use common\models\Event;
use common\models\EventCategory;
// use common\models\EventSearch;
use backend\models\search\EventSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * EventController implements the CRUD actions for Event model.
 */
class EventController extends Controller
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
     * Lists all Event models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categories' => EventCategory::find()->active()->all(),
            'cities' => City::find()->all()
        ]);
    }

    /**
     * Displays a single Event model.
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
     * Creates a new Event model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Event();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->imageFile){
                $model->uploadMainImage();
            }
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if ($model->imageFiles){
                $model->uploadGallery();
            }

            Yii::$app->session->setFlash('success', "Успешно создано");
            return $this->refresh();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Event model.
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
                $model->uploadMainImage();
            }
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if ($model->imageFiles){
                $model->uploadGallery();
            }
            
            Yii::$app->session->setFlash('success', "Успешно создано");
            return $this->refresh();
        }

        return $this->render('update', [
            'model' => $model,
            'categories' => EventCategory::find()->active()->all(),
            'cities' => City::find()->all()
        ]);
    }

    /**
     * Deletes an existing Event model.
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

        $place = Event::findOne($id);

        $imageId = Yii::$app->request->get('imageId');
        $images = $place->getImages();
        foreach ($images as $image) {
            if ($image->id == $imageId) {
                $place->removeImage($image);
            }
        }
        return $this->redirect(["/event/update", "id" => $id]);
    }

    public function actionMultipleDelete()
    {
        if (Yii::$app->request->post('id')) {
            Event::updateAll(['status' => 0], ['id' => Yii::$app->request->post('id')]);
        }
        Yii::$app->session->setFlash('success', 'Успешно удалено');
        return $this->redirect(Yii::$app->request->referrer);

    }

    public function actionMultipleChangeStatus()
    {
        if (Yii::$app->request->post('id','status')) {
            Event::updateAll(['status' => Yii::$app->request->post('status')], ['id' => Yii::$app->request->post('id')]);
        }
        Yii::$app->session->setFlash('success', 'Успешно изменено');
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionMultipleChangeCategory()
    {
        if (Yii::$app->request->post('id', 'category_id')) {
            Event::updateAll(['category_id' => Yii::$app->request->post('category_id')], ['id' => Yii::$app->request->post('id')]);
        }
        Yii::$app->session->setFlash('success', 'Успешно изменено');
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionMultipleChangeCity()
    {
        if (Yii::$app->request->post('id', 'city_id')) {
            Event::updateAll(['city_id' => Yii::$app->request->post('city_id')], ['id' => Yii::$app->request->post('id')]);
        }
        Yii::$app->session->setFlash('success', 'Успешно изменено');
        return $this->refresh();
    }

    /**
     * Finds the Event model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Event the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Event::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('backend', 'The requested page does not exist.'));
    }
}
