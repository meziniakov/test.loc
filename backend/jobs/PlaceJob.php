<?php
namespace backend\jobs;

use yii\helpers\Json;
use yii\base\BaseObject;
use common\models\Place;
use common\models\PlaceCategory;
use common\models\City;

class PlaceJob extends BaseObject implements \yii\queue\JobInterface
{
    public $object;
    public $pathinfo;

    public function behaviors()
    {
        return [
            // 'image' => [
            //     'class' => 'alex290\yii2images\behaviors\ImageBehave',
            // ],
            // [
            //     'class' => SluggableBehavior::class,
            //     'attribute' => 'title',
            //     'ensureUnique' => true,
            //     'immutable' => true,
            // ],
        ];
    }

    public function execute($queue)
    {
        $object = $this->object;

        if (!Place::findOne(['title' => $object->name])) {
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

            $place->save();

            if (isset($object->image)) {
                $pathinfo = pathinfo($object->image->url);
                $place->download($object->image->url, $pathinfo);
                $place->uploadImage($this->pathinfo, $object);
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
            return true;
        }
    }
}