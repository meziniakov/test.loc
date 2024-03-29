<?php

namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\models\search\ArticleSearch;
use common\models\Article;
use common\models\Place;
use common\models\ArticleCategory;
use common\models\City;
use common\models\PlaceCategory;
use zakurdaev\editorjs\actions\UploadImageAction;
use yii\web\UploadedFile;
use yii\helpers\Json;
use nickdenry\grid\toggle\actions\ToggleAction;

/**
 * Class ArticleController.
 */
class ArticleController extends Controller
{
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
            'upload-file' => [
                'class' => UploadImageAction::class,
                'mode' => UploadImageAction::MODE_FILE,
                'url' => Yii::getAlias('@storageUrl/img'),
                'path' => '@storage/img',
                'validatorOptions' => [
                    'maxWidth' => 2000,
                    'maxHeight' => 2000
                ]
            ],
            'fetch-url' => [
                'class' => UploadImageAction::class,
                'mode' => UploadImageAction::MODE_URL,
                'url' => Yii::getAlias('@storageUrl/img'),
                'path' => '@storage/img',
                'validatorOptions' => [
                    'maxWidth' => 1000,
                    'maxHeight' => 1000
                ]
            ],
            'switch' => [
                'class' => ToggleAction::class,
                'modelClass' => 'common\models\Article', // Your model class
            ],
        ];
    }
    /**
     * Lists all Article models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->sort = [
            'defaultOrder' => ['published_at' => SORT_DESC],
        ];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'cities' => City::find()->all(),
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->imageFile) {
                $model->uploadMainImage();
            }
            Yii::$app->session->setFlash('success', "Успешно создано");
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'categories' => ArticleCategory::find()->active()->all(),
                'cities' => City::find()->all()
            ]);
        }
    }

    public function actionGenerate()
    {
        $model = new Article();

        if ($model->load(Yii::$app->request->post())) {
            $places = Place::find()->where(['city_id' => $model->_city_id])->andWhere(['category_id' => $model->_category_id])->limit($model->_limit)->all();
            $text = [];
            $info = [];
            foreach ($places as $key => $place) {
                if (!empty($place->address)) {
                    $info[] = "<strong>Адрес:</strong> " . $place->address;
                }
                if (!empty($place->website)) {
                    $info[] = "<strong>Сайт:</strong> " . $place->website;
                }
                // $text[] = [
                //     'type' => 'paragraph',
                //     'data' => [
                //         'text' => $info,
                //     ]
                // ];

                $text[] = [
                    'type' => 'header',
                    'data' => [
                        'text' => $place->title,
                        'level' => 2
                    ]
                ];

                $text[] = [
                    'type' => 'image',
                    'data' => [
                        'file' => [
                            'url' => $place->getImage()->getUrl()
                        ],
                        'caption' => $place->title
                    ]
                ];

                $gallery = [];
                foreach ($place->getImages() as $image) {
                        $gallery[] = [
                            'url' => $image->getUrl(),
                            'caption' => $place->title
                        ];
                }

                $text[] = [
                    'type' => 'carousel',
                    'data' => $gallery
                ];

                $text[] = [
                    'type' => 'paragraph',
                    'data' => [
                        'text' => $place->text
                    ]
                ];
            }
            $data = [
                'blocks' => 
                    $text,
            ];
            $model->json = Json::encode($data);
            $model->save();
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->imageFile) {
                $model->uploadMainImage();
            }
            Yii::$app->session->setFlash('success', "Успешно создано");
            return $this->refresh();
        } else {
            return $this->render('generate', [
                'model' => $model,
                'categories' => ArticleCategory::find()->active()->all(),
                'place_categories' => PlaceCategory::find()->active()->all(),
                'cities' => City::find()->all()
            ]);
        }
    }


    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->imageFile) {
                $model->uploadMainImage();
            }
            Yii::$app->session->setFlash('success', "Успешно обновлено");
            return $this->refresh();
        } else {
            return $this->render('update', [
                'model' => $model,
                'cities' => City::find()->all(),
                'categories' => ArticleCategory::find()->active()->all(),
            ]);
        }
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
