<?php
namespace backend\jobs;

use Yii;
use yii\helpers\Json;
use yii\web\UploadedFile;
use yii\base\BaseObject;
use backend\modules\parser\models\JsonParser;
use common\models\Article;
use common\models\Place;
USE common\models\Page;
use common\models\PlaceCategory;
use common\models\City;
use common\models\Event;
use common\models\EventCategory;
use yii\web\NotFoundHttpException;

class EventJob extends BaseObject implements \yii\queue\JobInterface
{
    public $object;
    public $pathinfo;

    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'alex290\yii2images\behaviors\ImageBehave',
            ],
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                'ensureUnique' => true,
                'immutable' => true,
            ],
        ];
    }

    public function execute($queue)
    {
        $object = $this->object;

        if ($event = Event::findOne(['title' => $object->name])) {
            // $event->start = strtotime($object->start);
            // $event->end = strtotime($object->end);
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
            $event->save(false);
        }
        else {
            $event = new Event();
            $event->src_id = $object->id;
            $event->title = $object->name;
            $event->text = $object->description;
            $event->preview = $object->shortDescription;
            if(!empty($object->end)){
                $event->start = strtotime($object->start);
                $event->end = strtotime($object->end);
            }
            $event->organizer = $object->organizer;
            
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
                $event->uploadImage($this->pathinfo, $object);
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
        }
    }
}