<?php

namespace backend\controllers;

use Yii;
use common\models\Place;
use common\models\City;
use backend\models\search\PlaceSearch;
use common\models\PlaceCategory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use nickdenry\grid\toggle\actions\ToggleAction;
use yii\data\ActiveDataProvider;

/**
 * PlaceController implements the CRUD actions for Place model.
 */
class PlaceController extends Controller
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
                'modelClass' => 'common\models\Place', // Your model class
            ],
        ];
    }

    public $all;
    public $parsed;
    public $edited;
    public $published;
    public $updated;
    public $trashed;
    public $cities;
    public $categories;

    public function init()
    {
        parent::init();
        $this->all = Place::find()->count();
        $this->trashed = Place::find()->where(['=', 'status', Place::STATUS_TRASHED])->count();
        $this->parsed = Place::find()->where(['=', 'status', Place::STATUS_PARSED])->count();
        $this->edited = Place::find()->where(['=', 'status', Place::STATUS_EDITED])->count();
        $this->published = Place::find()->where(['=', 'status', Place::STATUS_PUBLISHED])->count();
        $this->updated = Place::find()->where(['=', 'status', Place::STATUS_UPDATED])->count();
        $this->cities = City::find()->groupBy('name', 'id')->all();
        $this->categories = PlaceCategory::find()->active()->all();
    }

    /**
     * Lists all Place models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'searchModel' => $searchModel = new PlaceSearch(),
            'dataProvider' => $searchModel->search(Yii::$app->request->queryParams),
            'categories' => $this->categories,
            'cities' => $this->cities
        ]);
    }

    /**
     * Lists all Place models.
     * @return mixed
     */
    public function actionParsed()
    {
        return $this->render('status', [
            'searchModel' => $searchModel = new PlaceSearch(),
            'data' => $searchModel->searchByStatus(Yii::$app->request->queryParams, Place::STATUS_PARSED, $this->parsed),
            'categories' => $this->categories,
            'cities' => $this->cities,
        ]);
    }

    /**
     * Lists all Place models.
     * @return mixed
     */
    public function actionEdited()
    {
        return $this->render('status', [
            'searchModel' => $searchModel = new PlaceSearch(),
            'data' => $searchModel->searchByStatus(Yii::$app->request->queryParams, Place::STATUS_EDITED, $this->edited),
            'cities' => $this->cities,
            'categories' => $this->categories,
        ]);
    }

    /**
     * Lists all Place models.
     * @return mixed
     */
    public function actionPublished()
    {
        return $this->render('status', [
            'searchModel' => $searchModel = new PlaceSearch(),
            'data' => $searchModel->searchByStatus(Yii::$app->request->queryParams, Place::STATUS_PUBLISHED, $this->published),
            'cities' => $this->cities,
            'categories' => $this->categories,
        ]);
    }

    /**
     * Lists all Place models.
     * @return mixed
     */
    public function actionUpdated()
    {
        return $this->render('status', [
            'searchModel' => $searchModel = new PlaceSearch(),
            'data' => $searchModel->searchByStatus(Yii::$app->request->queryParams, Place::STATUS_UPDATED, $this->updated),
            'categories' => $this->categories,
            'cities' => $this->cities,
        ]);
    }

    public function actionTrashed()
    {
        return $this->render('status', [
            'searchModel' => $searchModel = new PlaceSearch(),
            'data' => $searchModel->searchByStatus(Yii::$app->request->queryParams, Place::STATUS_TRASHED, $this->trashed),
            'cities' => $this->cities,
            'categories' => $this->categories,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Place();

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
            'categories' => $this->categories,
            'cities' => $this->cities
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->imageFile){
                $model->frameImage();
                // $model->uploadMainImage();
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
            'categories' => $this->categories,
            'cities' => $this->cities
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Успешно удалено');
        return $this->redirect(['index']);
    }

    public function actionDeletemoreimg($id){

        $place = Place::findOne($id);

        $imageId = Yii::$app->request->get('imageId');
        $images = $place->getImages();
        foreach ($images as $image) {
            if ($image->id == $imageId) {
                $place->removeImage($image);
            }
        }
        return $this->redirect(["/place/update", "id" => $id]);
    }

    public function actionMultipleDelete()
    {
        if (Yii::$app->request->post('id')) {
            Place::updateAll(['status' => 0], ['id' => Yii::$app->request->post('id')]);
        }
        Yii::$app->session->setFlash('success', 'Успешно удалено');
        return $this->redirect(Yii::$app->request->referrer);

    }

    public function actionMultipleChangeStatus()
    {
        if (Yii::$app->request->post('id','status')) {
            Place::updateAll(['status' => Yii::$app->request->post('status')], ['id' => Yii::$app->request->post('id')]);
        }
        Yii::$app->session->setFlash('success', 'Успешно изменено');
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionMultipleChangeCategory()
    {
        if (Yii::$app->request->post('id', 'category_id')) {
            Place::updateAll(['category_id' => Yii::$app->request->post('category_id')], ['id' => Yii::$app->request->post('id')]);
        }
        Yii::$app->session->setFlash('success', 'Успешно изменено');
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionMultipleChangeCity()
    {
        if (Yii::$app->request->post('id', 'city_id')) {
            Place::updateAll(['city_id' => Yii::$app->request->post('city_id')], ['id' => Yii::$app->request->post('id')]);
        }
        Yii::$app->session->setFlash('success', 'Успешно изменено');
        return $this->refresh();
    }

    protected function findModel($id)
    {
        if (($model = Place::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
