<?php

namespace backend\controllers;

use Yii;
use common\models\Place;
use common\models\City;
use backend\models\PlaceSearch;
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

    public $all = 10;
    public $parsed = 1;
    public $edited = 2;
    public $published = 3;
    public $updated = 4;
    public $trashed = 0;

    public function init()
    {
        parent::init();
        $this->all = Place::find()->count();
        $this->trashed = Place::find()->where(['=', 'status', Place::STATUS_TRASHED])->count();
        $this->parsed = Place::find()->where(['=', 'status', Place::STATUS_PARSED])->count();
        $this->edited = Place::find()->where(['=', 'status', Place::STATUS_EDITED])->count();
        $this->published = Place::find()->where(['=', 'status', Place::STATUS_PUBLISHED])->count();
        $this->updated = Place::find()->where(['=', 'status', Place::STATUS_UPDATED])->count();
        }

    /**
     * Lists all Place models.
     * @return mixed
     */
    public function actionIndex()
    {
        $img = '';
        $searchModel = new PlaceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $categories = PlaceCategory::find()->active()->all();
        $cities = City::find()->all();
        // var_dump($categories);die;
        // $img = $dataProvider->getImage();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'img' => $img,
            'dataProvider' => $dataProvider,
            'categories' => $categories,
            'cities' => $cities
        ]);
    }

    /**
     * Lists all Place models.
     * @return mixed
     */
    // public function actionIndex()
    // {
    //     $searchModel = new PlaceSearch();

    //     return $this->render('status', [
    //         'searchModel' => $searchModel,
    //         'categories' => PlaceCategory::findAll(['status' => 1]),
    //         'data' => new ActiveDataProvider([
    //             // 'query' => Place::find()->with('category', 'city'),
    //             'query' => $searchModel->search(Place::find()->with('category', 'city')-),
    //             'totalCount' => $this->all,
    //                 ])
    //     ]);
    // }
    /**
     * Lists all Place models.
     * @return mixed
     */
    public function actionParsed()
    {
        $searchModel = new PlaceSearch();

        return $this->render('status', [
            'searchModel' => $searchModel,
            'categories' => PlaceCategory::findAll(['status' => 1]),
            'cities' => City::find()->all(),
            'data' => new ActiveDataProvider([
                'query' => Place::find()->with('category', 'city')->where(['=', 'status', Place::STATUS_PARSED]),
                'totalCount' => $this->parsed,
                    ])
        ]);
    }

    /**
     * Lists all Place models.
     * @return mixed
     */
    public function actionEdited()
    {
        $searchModel = new PlaceSearch();

        return $this->render('status', [
            'searchModel' => $searchModel,
            'cities' => City::find()->all(),
            'categories' => PlaceCategory::findAll(['status' => 1]),
            'data' => new ActiveDataProvider([
                'query' => Place::find()->with('category', 'city')->where(['=', 'status', Place::STATUS_EDITED]),
                'totalCount' => $this->edited
                    ])
        ]);
    }

    /**
     * Lists all Place models.
     * @return mixed
     */
    public function actionPublished()
    {
        $searchModel = new PlaceSearch();

        return $this->render('status', [
            'searchModel' => $searchModel,
            'cities' => City::find()->all(),
            'categories' => PlaceCategory::findAll(['status' => 1]),
            'data' => new ActiveDataProvider([
                'query' => Place::find()->with('category', 'city')->where(['=', 'status', Place::STATUS_PUBLISHED]),
                'totalCount' => $this->published
                    ])
        ]);
    }

    /**
     * Lists all Place models.
     * @return mixed
     */
    public function actionUpdated()
    {
        $searchModel = new PlaceSearch();

        return $this->render('status', [
            'searchModel' => $searchModel,
            'categories' => PlaceCategory::findAll(['status' => 1]),
            'cities' => City::find()->all(),
            'data' => new ActiveDataProvider([
                'query' => Place::find()->with('category', 'city')->where(['=', 'status', Place::STATUS_UPDATED]),
                'totalCount' => $this->updated
                    ])
        ]);
    }

    public function actionTrashed()
    {
        $searchModel = new PlaceSearch();

        return $this->render('status', [
            'searchModel' => $searchModel,
            'cities' => City::find()->all(),
            'categories' => PlaceCategory::findAll(['status' => 1]),
            'data' => new ActiveDataProvider([
                'query' => Place::find()->with('category', 'city')->where(['=', 'status', Place::STATUS_TRASHED]),
                'totalCount' => $this->trashed
                    ])
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
                var_dump($model->imageFiles);die;
            }
            $model->uploadGallery();
            
            Yii::$app->session->setFlash('success', "Успешно создано");
            
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'categories' => PlaceCategory::find()->active()->all(),
            'cities' => City::find()->all()
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
            
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'categories' => PlaceCategory::find()->active()->all(),
            'cities' => City::find()->all()
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
        return $this->redirect(Yii::$app->request->referrer);
    }

    protected function findModel($id)
    {
        if (($model = Place::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
