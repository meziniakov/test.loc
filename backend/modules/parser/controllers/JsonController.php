<?php

namespace backend\modules\parser\controllers;

use Yii;
use backend\modules\parser\models\JsonParser;
use common\models\City;
use common\models\Event;
use common\models\EventCategory;
use common\models\Place;
use common\models\PlaceCategory;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\UploadedFile;
use backend\jobs\PlaceJob;
use backend\jobs\EventJob;
use backend\modules\parser\models\JsonForm;

class JsonController extends Controller
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

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => JsonParser::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPlace()
    {
        $model = new JsonForm();
        if ($model->load(Yii::$app->request->post())) {
            $model->jsonFile = UploadedFile::getInstance($model, 'jsonFile');
            if ($model->jsonFile) {
                $path = $model->uploadJsonFile();
            }
            $json = file_get_contents($path, true);
            $array = Json::decode($json, false);

            $countSave = 0;
            foreach ($array as $object) {    
                if(Yii::$app->queue->push(new PlaceJob([
                    'object' => $object = $object->data->general,
                    'pathinfo' => pathinfo($object->image->url),
                ]))) {
                    $countSave++;
                }
            }
            Yii::$app->session->setFlash('success', "Успешно обновлено  записей\rn Успешно запущено {$countSave} записей в очередь.");
        }

        return $this->render('job', [
            'model' => $model,
        ]);
    }

    public function actionEvent()
    {
        $model = new JsonForm();
        if ($model->load(Yii::$app->request->post())) {
            $model->jsonFile = UploadedFile::getInstance($model, 'jsonFile');
            if ($model->jsonFile) {
                $path = $model->uploadJsonFile();
            }
            $json = file_get_contents($path, true);
            $array = Json::decode($json, false);

            $countSave = 0;

            foreach ($array as $object) {
                if(Yii::$app->queue->push(new EventJob([
                    'object' => $object = $object->data->general,
                    'pathinfo' => pathinfo($object->image->url),
                ]))) {
                    $countSave++;
                }
            }
            Yii::$app->session->setFlash('success', "Успешно запущено {$countSave} записей в очередь.");
        }

        return $this->render('job', [
            'model' => $model,
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
        $model = new JsonParser();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->jsonFile = UploadedFile::getInstance($model, 'jsonFile');
            if ($model->jsonFile) {
                $model->uploadJsonFile();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = JsonParser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('backend', 'The requested page does not exist.'));
    }

    public function actionTest()
    {
        $path = Yii::getAlias('@storage') . '/json/test2.json';
        $json = file_get_contents($path, true);
        $array = Json::decode($json, false);

        $res = [];
        foreach ($array as $object) {
            $res[] = [
                'title' => $object->data->general->name,
                'text' => $object->data->general->description,
                'city_name' => $object->data->general->locale->name,
                'city_sys_name' => $object->data->general->locale->sysName,
                'city_src_id' => $object->data->general->locale->id,
                'street' => $object->data->general->address->street,
                'street_comment' => $object->data->general->address->comment,
                'full_address' => $object->data->general->address->fullAddress,
                'lng' => $object->data->general->address->mapPosition->coordinates[0],
                'lat' => $object->data->general->address->mapPosition->coordinates[1],
                'category_name' => $object->data->general->category->name,
                'category_sys_name' => $object->data->general->category->sysName,
                'image_url' => $object->data->general->image->url,
                'image_alt' => $object->data->general->image->title,
                'website' => $object->data->general->contacts->website,
                'email' => $object->data->general->contacts->email,
            ];
            if (!empty($object->data->general->contacts->phones)) {
                foreach ($object->data->general->contacts->phones as $phone) {
                    $res[] = [
                        'phones' => $phone->value,
                        'phones_comment' => $phone->comment,
                    ];
                }
            }
            if (!empty($object->data->general->gallery)) {
                foreach ($object->data->general->gallery as $image) {
                    $res[] = [
                        'gallery_url' => $image->url,
                        'gallery_alt' => $image->title,
                    ];
                }
            }
            if (!empty($object->data->general->tags)) {
                foreach ($object->data->general->tags as $tag) {
                    $res[] = [
                        'tag_name' => $tag->name,
                        'tag_sys_name' => $tag->sysName,
                    ];
                }
            }
            if (!empty($object->data->general->workingSchedule)) {
                foreach ($object->data->general->workingSchedule as $dn => $item) {
                    $res[] = [
                        'working_schedule' => '{"' . $dn . '":{"from":"' . $item->from . '","to":"' . $item->to . '"}',
                    ];
                }
            }
        }
        return $this->render('test', [
            'result' => $res
        ]);
    }

    public function actionStart($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //загружаем файл и читаем json файл в массив
            $model->jsonFile = UploadedFile::getInstance($model, 'jsonFile');
            if ($model->jsonFile) {
                $model->uploadJsonFile();
            }
            $path = Yii::getAlias('@storage') . '/json/'. $model->jsonFile->name;
            $json = file_get_contents($path, true);
            $array = Json::decode($json, false);

            $countUpdate = 0;
            $countSave = 0;

            foreach ($array as $object) {
                $object = $object->data->general;

                //Если по названию в базе находим объект - обновляем его
                if ($place = Place::findOne(['title' => $object->name])) {
                    $place->src_id = $object->id;
                    $place->text = $object->description;
                    $place->address = $object->address->fullAddress;
                    $place->street = $object->address->street;
                    $place->street_comment = $object->address->comment;
                    $place->lng = $object->address->mapPosition->coordinates[0];
                    $place->lat = $object->address->mapPosition->coordinates[1];
                    if(isset($object->contacts->email)) {
                        $place->email = $object->contacts->email;
                    }
                    if(isset($object->contacts->website)) {
                        $place->website = $object->contacts->website;
                    }
                    $place->status = 4;

                    // Если в массиве есть поле с phones, перебираем их и забираем данные
                    if (isset($object->contacts->phones)) {
                        $phones = [];
                        foreach ($object->contacts->phones as $phone) {
                            $phones[] = ['phones' => $phone->value, 'phones_comment' => $phone->comment];
                        }
                        Json::encode($phones);
                        $place->phone = $phones;
                    }
                    // Если в массиве есть поле с workingSchedule, перебираем их и забираем данные
                    if (isset($object->workingSchedule)) {
                        $_workingSchedule = [];
                        foreach($object->workingSchedule as $key => $item) {
                            $_workingSchedule[] = $key = [
                                'from' => strtotime($item->from),
                                'to' => strtotime($item->to),
                            ];
                        }
                        // $workingSchedule = array_combine($daysweek, $_workingSchedule);
                        $workingScheduleJson = Json::encode($_workingSchedule);
                        $place->schedule = $workingScheduleJson;
                    }
                    // Если в массиве есть поле с tags, перебираем их и забираем данные
                    // var_dump($object->tags);die;
                    if (isset($object->tags)) {
                        $tags = [];
                        foreach ($object->tags as $tag) {
                            $tags[] = $tag->name;
                        }
                        // var_dump($tags);die;
                        $place->addTagValues($tags);
                    }

                    if (isset($object->image)) {
                        $pathinfo = pathinfo($object->image->url);
                        if ($place->getImage()->name !== $pathinfo['filename']) {
                            $place->download($object->image->url, $pathinfo);
                            //название файла без расширения
                            //preg_replace('/\.\w+$/', '', $object->image->title)
                            $place->uploadImage($pathinfo, $object);
                        } else {
                            $image = \alex290\yii2images\models\Image::findOne(['name' => $pathinfo['filename']]);
                            $image->alt = $object->name;
                            $image->title = $object->name;
                            $image->save(false);
                        }
                    }

                    if (isset($object->gallery)) {
                        foreach ($object->gallery as $image) {
                            $pathinfo = pathinfo($image->url);
                            if ($place->getImage()->name !== $pathinfo['filename']) {
                                $place->images[] = $pathinfo;
                                $place->download($image->url, $pathinfo);
                            } else {
                                $image = \alex290\yii2images\models\Image::findOne(['name' => $pathinfo['filename']]);
                                $image->alt = $object->name;
                                $image->title = $object->name;
                                $image->save(false);
                            }
                        }
                        if ($imageFiles = $place->images) {
                            $place->uploadImages($imageFiles, $object);
                        }
                    }
                    $place->save(false);
                    $countUpdate++;
                } else {
                    $place = new Place();
                    $place->src_id = $object->id;
                    $place->title = $object->name;
                    $place->text = $object->description;
                    $place->address = $object->address->fullAddress;
                    $place->street = $object->address->street;
                    $place->street_comment = $object->address->comment;
                    $place->lng = $object->address->mapPosition->coordinates[0];
                    $place->lat = $object->address->mapPosition->coordinates[1];
                    if(isset($object->contacts->email)) {
                        $place->email = $object->contacts->email;
                    }
                    if(isset($object->contacts->website)) {
                        $place->website = $object->contacts->website;
                    }
                    $place->status = 1;

                    if ($placeCategory = PlaceCategory::findOne(['title' => $object->category->name])) {
                        $place->category_id = $placeCategory->id;
                    } else {
                        $category = new PlaceCategory();
                        $category->title = $object->category->name;
                        $category->slug = $object->category->sysName;
                        $category->save();
                        $place->category_id = $category->id;
                    }

                    if ($city = City::findOne(['name' => $object->locale->name])) {
                        $place->city_id = $city->id;
                    } else {
                        $city = new City();
                        $city->name = $object->locale->name;
                        $city->url = $object->locale->sysName;
                        $city->save();
                        $place->city_id = $city->id;
                    }

                    // Если в массиве есть поле с phones, перебираем их и забираем данные
                    if (isset($object->contacts->phones)) {
                        $phones = [];
                        foreach ($object->contacts->phones as $phone) {
                            $phones[] = ['phones' => $phone->value, 'phones_comment' => $phone->comment];
                        }
                        Json::encode($phones);
                        $place->phone = $phones;
                    }
                    // Если в массиве есть поле с workingSchedule, перебираем их и забираем данные
                    if (isset($object->workingSchedule)) {
                        $daysweek = [1 => 'Понедельник', 2 => 'Вторник', 3 => 'Среда', 4 => 'Четверг', 5 => 'Пятница', 6 => 'Суббота', 7 => 'Воскресенье'];
                        $_workingSchedule = [];
                        foreach($object->workingSchedule as $key => $item) {
                            $_workingSchedule[] = $key = [
                                'from' => strtotime($item->from),
                                'to' => strtotime($item->to),
                            ];
                        }
                        // $workingSchedule = array_combine($daysweek, $_workingSchedule);
                        $workingScheduleJson = Json::encode($_workingSchedule);
                        $place->schedule = $workingScheduleJson;
                    }
                    // Если в массиве есть поле с tags, перебираем их и забираем данные
                    if (isset($object->tags)) {
                        $tags = [];
                        foreach ($object->tags as $tag) {
                            $tags[] = trim(str_replace("\n", "", strpos($tag->name, '.')));
                        }
                        $place->addTagValues($tags);
                    }

                    $place->save(false);

                    if (isset($object->image)) {
                        $pathinfo = pathinfo($object->image->url);
                        $place->download($object->image->url, $pathinfo);
                        $place->uploadImage($pathinfo, $object);
                    }

                    if (isset($object->gallery)) {
                        foreach ($object->gallery as $image) {
                            $pathinfo = pathinfo($image->url);
                            $place->images[] = $pathinfo;
                            $place->download($image->url, $pathinfo);
                        }
                        $imageFiles = $place->images;
                        $place->uploadImages($imageFiles, $object);
                    }
                    $countSave++;
                }
            }
            Yii::$app->session->setFlash('success', "Успешно обновлено {$countUpdate} записей\rn Успешно сохарнено {$countSave} записей.");
        }

        return $this->render('start', [
            'model' => $model,
        ]);
    }

    public function actionEvent_($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //загружаем файл и читаем json файл в массив
            $model->jsonFile = UploadedFile::getInstance($model, 'jsonFile');
            if ($model->jsonFile) {
                $model->uploadJsonFile();
            }
            $path = Yii::getAlias('@storage') . '/json/'. $model->jsonFile->name;
            $json = file_get_contents($path, true);
            $array = Json::decode($json, false);

            $countUpdate = 0;
            $countSave = 0;

            foreach ($array as $object) {
                $object = $object->data->general;

                //Если по названию в базе находим объект - обновляем его
                if ($event = Event::findOne(['title' => $object->name])) {
                    $event->src_id = $object->id;
                    $event->text = $object->description;
                    $event->preview = $object->shortDescription;
                    $event->organizer = $object->organizer;
                    $event->start = strtotime($object->start);
                    $event->end = strtotime($object->end);
                    // $event->organizer_place_id = $object->organizerPlace->id;
                    // $event->organizer_place_name = $object->organizerPlace->name;
                    // $event->place_id = $object->organizerPlace->id;
                    $event->status = 4;

                    // Если в массиве есть поле с seances, перебираем их и забираем данные
                    if (isset($object->seances)) {
                        $_seances = [];
                        foreach($object->seances as $key => $item) {
                            $_seances[] = $key = [
                                'start' => strtotime($item->start),
                                'end' => strtotime($item->end),
                            ];
                        }
                        $seancesJson = Json::encode($_seances);
                        $event->seances = $seancesJson;
                    }
                    // Если в массиве есть поле с tags, перебираем их и забираем данные
                    // if (isset($object->tags)) {
                    //     $tags = [];
                    //     foreach ($object->tags as $tag) {
                    //         $tags[] = $tag->name;
                    //     }
                    //     $event->addTagValues($tags);
                    // }

                    // if (isset($object->image)) {
                    //     $pathinfo = pathinfo($object->image->url);
                    //     if ($event->getImage()->name !== $pathinfo['filename']) {
                    //         $event->download($object->image->url, $pathinfo);
                    //         //название файла без расширения
                    //         //preg_replace('/\.\w+$/', '', $object->image->title)
                    //         $event->uploadImage($pathinfo, $object);
                    //     } else {
                    //         $image = \alex290\yii2images\models\Image::findOne(['name' => $pathinfo['filename']]);
                    //         $image->alt = $object->name;
                    //         $image->title = $object->name;
                    //         $image->save(false);
                    //     }
                    // }

                    $event->save();
                    $countUpdate++;
                } else {
                    $event = new Event();
                    $event->src_id = $object->id;
                    $event->title = $object->name;
                    $event->text = $object->description;
                    $event->preview = $object->shortDescription;
                    $event->organizer = $object->organizer;
                    $event->start = strtotime($object->start);
                    $event->end = strtotime($object->end);
                    // $event->organizer_place_id = $object->organizerPlace->id;
                    // $event->organizer_place_name = $object->organizerPlace->name;
                    // $event->place_id = $object->organizerPlace->id;
                    $event->status = 1;

                    // if ($eventCategory = EventCategory::findOne(['title' => $object->category->name])) {
                    //     $event->category_id = $eventCategory->id;
                    // } else {
                    //     $category = new EventCategory();
                    //     $category->title = $object->category->name;
                    //     $category->slug = $object->category->sysName;
                    //     $category->save();
                    //     $event->category_id = $category->id;
                    // }

                    // if ($city = City::findOne(['name' => $object->organization->locale->name])) {
                    //     $event->city_id = $city->id;
                    // } else {
                    //     $city = new City();
                    //     $city->name = $object->organization->locale->name;
                    //     $city->url = $object->organization->locale->sysName;
                    //     $city->save();
                    //     $event->city_id = $city->id;
                    // }

                    // Если в массиве есть поле с workingSchedule, перебираем их и забираем данные
                    // if (isset($object->seances)) {
                    //     $daysweek = [1 => 'Понедельник', 2 => 'Вторник', 3 => 'Среда', 4 => 'Четверг', 5 => 'Пятница', 6 => 'Суббота', 7 => 'Воскресенье'];
                    //     $_seances = [];
                    //     foreach($object->seances as $key => $item) {
                    //         $_seances[] = $key = [
                    //             'start' => strtotime($item->start),
                    //             'end' => strtotime($item->end),
                    //         ];
                    //     }
                    //     // $workingSchedule = array_combine($daysweek, $_workingSchedule);
                    //     $seancesJson = Json::encode($_seances);
                    //     $event->seances = $seancesJson;
                    // }
                    // // Если в массиве есть поле с tags, перебираем их и забираем данные
                    // if (isset($object->tags)) {
                    //     $tags = [];
                    //     foreach ($object->tags as $tag) {
                    //         $tags[] = trim(str_replace("\n", "", strpos($tag->name, '.')));
                    //     }
                    //     $event->addTagValues($tags);
                    // }

                    $event->save(false);

                    // if (isset($object->image)) {
                    //     $pathinfo = pathinfo($object->image->url);
                    //     $event->download($object->image->url, $pathinfo);
                    //     $event->uploadImage($pathinfo, $object);
                    // }
                    $countSave++;
                }
            }
            Yii::$app->session->setFlash('success', "Успешно обновлено {$countUpdate} записей\rn <br> Успешно сохарнено {$countSave} записей.");
        }

        return $this->render('event', [
            'model' => $model,
        ]);
    }
}
