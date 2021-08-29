<?php

namespace backend\modules\parser\controllers;

use backend\helpers\WebConsole;
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
use backend\jobs\CreatePlaceJob;
use backend\jobs\UpdatePlaceJob;
use backend\jobs\EventJob;
use backend\modules\parser\models\JsonForm;
use common\models\Area;
use common\models\FederalDistrict;
use common\models\Region;
use yii\helpers\Console;
use yii\helpers\FileHelper;

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
            if($model->jsonFile = UploadedFile::getInstance($model, 'jsonFile')) {
                $path = $model->uploadJsonFile();
            } else {
                $path = $model->jsonFileByURL;
            }
            $json = file_get_contents($path, true);
            $array = Json::decode($json, false);

            $countCreate = 0;
            $countUpdate = 0;
            foreach ($array as $object) {
                $object = $object->data->general;

                if (Place::findOne(['title' => $object->name])) {
                    Yii::$app->queue->push(new UpdatePlaceJob([
                        'object' => $object,
                    ]));
                    $countUpdate++;
                } else {
                    Yii::$app->queue->push(new CreatePlaceJob([
                        'object' => $object,
                        'pathinfo' => pathinfo($object->image->url),
                    ]));
                    $countCreate++;
                }
            }
            Yii::$app->session->setFlash('success', "Добавлено в очередь новых мест: {$countCreate} <br> Добавлено в очередь мест для обновления: {$countUpdate}");
        }

        return $this->render('job', [
            'model' => $model,
        ]);
    }
    public function actionDa()
    {
        $model = new JsonForm();
        if ($model->load(Yii::$app->request->post())) {
            if($model->jsonFile = UploadedFile::getInstance($model, 'jsonFile')) {
                $path = $model->uploadJsonFile();
            } else {
                $path = $model->jsonFileByURL;
            }
            $json = file_get_contents($path, true);
            $array = Json::decode($json, false);

            $countCreate = 0;
            $countUpdate = 0;
            foreach ($array as $object) {
                $object = $object->data->general;
                if ($place = Place::findOne(['title' => $object->name])) {
                    $dadata = new \Dadata\DadataClient(env('DADATA_TOKEN'), env('DADATA_SECRET'));
                    if(isset($object->address->fiasHouseId)) {
                        $response = $dadata->findById("address", $object->address->fiasHouseId);
                    } else {
                        $response = $dadata->findById("address", $object->address->fiasStreetId);                        
                    }
            
                    $place->title = $object->name;
                    $place->src_id = $object->id;
                    $place->status = Place::STATUS_UPDATED;
                    $place->text = $object->description;
            
                    $place->address = $object->address->fullAddress;
                    $place->street = $object->address->street;
                    $place->street_comment = $object->address->fiasStreetId;
                    
                    if(!$federal_district = FederalDistrict::findOne(['name' => $response[0]['data']['federal_district']])) {
                        $federal_district = new FederalDistrict();
                        $federal_district->name = $response[0]['data']['federal_district'];
                        $federal_district->country_id = 1;
                        $federal_district->save();
                    }
                    if(!$region = Region::findOne(['name' => $response[0]['data']['region']])) {
                        $region = new Region();
                        $region->federal_district_id = $federal_district->id;
                        $region->name = $response[0]['data']['region'];
                        $region->type = $response[0]['data']['region_type'];
                        $region->type_full = $response[0]['data']['region_type_full'];
                        $region->save();
                    }
                    if(!$area = Area::findOne(['name' => $response[0]['data']['area']])) {
                        $area = new Area();
                        $area->region_id = $region->id;
                        $area->name = $response[0]['data']['area'];
                        $area->type = $response[0]['data']['area_type'];
                        $area->type_full = $response[0]['data']['area_type_full'];
                        $area->save();
                    }
                    if(!empty($response[0]['data']['city'])) {
                        if ($city = City::findOne(['name' => $response[0]['data']['city']])) {
                            $place->city_id = $city->id;
                        } else {
                            $city = new City();
                            $city->name = $response[0]['data']['city'];
                            // $city->url = $object->locale->sysName;
                            $city->save();
                            $place->city_id = $city->id;
                        }
                    } else {
                        $city = new City();
                        $city->name = $response[0]['data']['settlement_with_type'];
                        // $city->url = $object->locale->sysName;
                        $city->save();
                        $place->city_id = $city->id;
                    }

                    $place->title = $object->name;
                    $place->text = $object->description;            
                    $place->slug = '';
                    $place->save();
                    $countUpdate++;
                // } else {
                //     Yii::$app->queue->push(new CreatePlaceJob([
                //         'object' => $object,
                //         'pathinfo' => pathinfo($object->image->url),
                //     ]));
                //     $countCreate++;
                }
            }
            Yii::$app->session->setFlash('success', "Добавлено в очередь мест для обновления: {$countUpdate}");
        }

        return $this->render('job', [
            'model' => $model,
        ]);
    }

    public function actionDadata()
    {
        $places = Place::find()->all();
        $dadata = new \Dadata\DadataClient(env('DADATA_TOKEN'), env('DADATA_SECRET'));
        // var_dump(($response = $dadata->findById("address", '')) == null);die;
        if(($response = $dadata->findById("address", '')) == null) {
            $response = $dadata->findById("address", '1d06c590-17ae-4264-b7a8-7af8008ff7ab');
        }
        // $response = $dadata->findById("address", '7f5d3322-1cfc-402d-94c9-6850c2f438d9');
        // $response = $dadata->findById("address", 'ab425a84-50ec-4941-b414-9ffd16c3a254');
        // $response = $dadata->findById("address", '591fad24-0be3-4765-ae5d-b3833f98635e');
        echo "<pre>";
        var_dump($response);die;

  
        $countCreate = 0;
        $countUpdate = 0;
        foreach ($places as $object) {
            $object = $object->data->general;

            if ($place = Place::findOne(['title' => $object->name])) {
                Yii::$app->queue->push(new UpdatePlaceJob([
                    'object' => $object,
                    'place' => $place,
                ]));
                $place->title = $object->name;
                $place->text = $object->description;            
                $place->slug = '';
                $place->save();
                $countUpdate++;
            } else {
                Yii::$app->queue->push(new CreatePlaceJob([
                    'object' => $object,
                    'pathinfo' => pathinfo($object->image->url),
                ]));
                $countCreate++;
            }
        }
        Yii::$app->session->setFlash('success', "Добавлено в очередь новых мест: {$countCreate} <br> Добавлено в очередь мест для обновления: {$countUpdate}");

    }

    public function actionPlaceTest()
    {
        $model = new JsonForm();
        if ($model->load(Yii::$app->request->post())) {
            if($model->jsonFile = UploadedFile::getInstance($model, 'jsonFile')) {
                $path = $model->uploadJsonFile();
            } else {
                $path = $model->jsonFileByURL;
            }
            $json = file_get_contents($path, true);
            $array = Json::decode($json, false);

            foreach ($array as $object) {
                $object = $object->data->general;
                if ($place = Place::findOne(['title' => $object->name])) {
                    $place->src_id = $object->id;
                    $place->slug = "";
                    $place->text = $object->description;
                    $place->address = $object->address->fullAddress;
                    $place->street = $object->address->street;
                    $place->status = Place::STATUS_UPDATED;
                    // Если в массиве есть поле с tags, перебираем их и забираем данные
                    if (isset($object->tags)) {
                        $tags = [];
                        foreach ($object->tags as $tag) {
                            $tags[] = $tag->name;
                        }
                        $place->addTagValues($tags);
                    }
                    $place->save();
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
                    $place->status = Place::STATUS_PARSED;
            
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
                            $tags[] = $tag->name;
                        }
                        $place->addTagValues($tags);
                    }
        
                    $place->save();
        
                    if (isset($object->image)) {
                        $pathinfo = pathinfo($object->image->url);
                        $place->download($object->image->url, $pathinfo);
                        $place->uploadImage($object->image->url, $object);
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
                }
            }
            // Yii::$app->session->setFlash('success', "Успешно обновлено {$countUpdate} записей в очереди.");
        }

        return $this->render('job', [
            'model' => $model,
        ]);
    }

    public function actionEvent()
    {
        $model = new JsonForm();
        if ($model->load(Yii::$app->request->post())) {
            if($model->jsonFile = UploadedFile::getInstance($model, 'jsonFile')) {
                $path = $model->uploadJsonFile();
            } else {
                $path = $model->jsonFileByURL;
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

    public function actionChunk()
    {
        $model = new JsonForm();
        if ($model->load(Yii::$app->request->post())) {
            $model->jsonFile = UploadedFile::getInstance($model, 'jsonFile');
            if ($model->jsonFile) {
                $path = $model->uploadJsonFile();
            }
            $json = file_get_contents($path, true);
            $array = Json::decode($json, false);

            $n = $model->parts;
            $to = 0;
            $countFile = 0;

            $res = array_chunk($array, $n);
            foreach($res as $item) {
                $last = count($item);
                $json = Json::encode($item);
                $from = $to + 1; //1 5
                $to = $from + $n; //4 8
                $filename = $model->jsonFile->baseName;
                $dir = Yii::getAlias('@storage') . '/json/events/'.$filename.'/';
                FileHelper::createDirectory($dir);
                $model->jsonFile->saveAs($dir.$filename.'.json');
                $path = $dir . $filename .'_'. $from .'-'. $to .'.json';
                if(file_put_contents($path, $json)) {
                    $countFile++;
                }
                // $json = file_get_contents($path, true);
                // $array = Json::decode($json, false);
                // $this->parser($array);
                // die;
            }
            Yii::$app->session->setFlash('success', "Успешно создано $countFile файлов. В " . --$countFile ." файлах по $n обЪектов. В последнем файле - $last объектов");
            // die;

        }
        
        return $this->render('job', [
            'model' => $model,
        ]);

    }

    public function parser($array)
    {
        $countSave = 0;

        foreach ($array as $object) {
            $object = $object->data->general;
            $event = new Event();
            $event->src_id = $object->id;
            $event->title = $object->name;
            $event->text = $object->description;
            $event->preview = $object->shortDescription;
            if(!empty($object->end)){
                $event->start = strtotime($object->start);
                $event->end = strtotime($object->end);
            }

            if(!empty($object->organizer)){
                $event->organizer = $object->organizer;
            }

            if(!empty($object->organizerPlace)) {
                $event->place_id = $object->organizerPlace->id;
                // $event->organizer_place_id = $object->organizerPlace->id;
                // $event->organizer_place_name = $object->organizerPlace->name;
            }
            if(!empty($object->ageRestriction)){
                $event->ageRestriction = $object->ageRestriction;
            }
            if(!empty($object->isFree)){
                $event->isFree = 1;
            } else {
                $event->isFree = 0;
            }
            $event->status = 1;

            if ($eventCategory = EventCategory::findOne(['title' => $object->category->name])) {
                $event->category_id = $eventCategory->id;
            } else {
                $category = new EventCategory();
                $category->title = $object->category->name;
                $category->slug = $object->category->sysName;
                $category->save();
                $event->category_id = $category->id;
            }

            if ($city = City::findOne(['name' => $object->organization->locale->name])) {
                $event->city_id = $city->id;
            } else {
                $city = new City();
                $city->name = $object->organization->locale->name;
                $city->url = $object->organization->locale->sysName;
                $city->save();
                $event->city_id = $city->id;
            }

            // Если в массиве есть поле с tags, перебираем их и забираем данные
            if (!empty($object->tags)) {
                $tags = [];
                foreach ($object->tags as $tag) {
                    $tags[] = trim(str_replace("\n", "", strpos($tag->name, '.')));
                }
                $event->addTagValues($tags);
            }

            $event->save();

            if (!empty($object->image)) {
                $pathinfo = pathinfo($object->image->url);
                $event->download($object->image->url, $pathinfo);
                $event->uploadImage($pathinfo, $object);
            }
    
            if (!empty($object->gallery)) {
                foreach ($object->gallery as $image) {
                    $pathinfo = pathinfo($image->url);
                    $event->images[] = $pathinfo;
                    $event->download($image->url, $pathinfo);
                }
                $imageFiles = $event->images;
                $event->uploadImages($imageFiles, $object);
            }
            $countSave++;
        }
        Yii::$app->session->setFlash('success', "Успешно запущено {$countSave} записей в очередь.");
    }

    public function actionInfo()
    {
        // $name = Console::input("Пожалуйста, введите Ваше имя:");
        // $formatName = Console::ansiFormat($name,[Console::FG_YELLOW]);
        // Console::output("Ваше имя: {$formatName}");
        // $hello = Console::ansiFormat("Hello",[Console::FG_YELLOW,Console::BG_BLUE]);
        // $hello = Console::ansiFormat("Hello",[Console::FG_YELLOW]);
        // $world = Console::ansiFormat("World",[Console::FG_GREEN]);
        // Console::output("{$hello} {$world}");
      
        // Console::output('Hello World');
        // Console::ansiFormat(null);
        // Console::output(Console::ansiFormat("negative",[Console::NEGATIVE]));
        // die;

        $output=null;
        $retval=null;
        exec('/usr/bin/php7.2 /var/www/yii2zif/test.loc/yii queue/info', $output, $retval);
        
        return $this->render('info', [
            'output' => $output,
            'time' => date('H:i:s'),
        ]);
    }

    public function actionPjaxRun()
    {
        $output=null;
        $retval=null;
        exec('/usr/bin/php7.2 /var/www/yii2zif/test.loc/yii queue/run --isolate', $output, $retval);
        
        return $this->redirect('/parser/json/info');
    }

    public function actionPjaxClear()
    {
        $output=null;
        $retval=null;
        exec('/usr/bin/php7.2 /var/www/yii2zif/test.loc/yii queue/clear', $output, $retval);
        
        return $this->redirect('/parser/json/info');
    }
}
