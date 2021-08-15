<?php
namespace backend\jobs;

use yii\helpers\Json;
use yii\base\BaseObject;
use common\models\Place;
use common\models\PlaceCategory;
use common\models\City;

class CreateTestPlaceJob extends BaseObject implements \yii\queue\JobInterface
{
    public $title;
    public $place;

    public function execute($queue)
    {
        $title = $this->title;
        $place = $this->place;
        $place->src_id = '0010';
        $place->title = $title;
        $place->slug = "";
        $place->text = "Текст 8";
        // $place->address = $object->address->fullAddress;
        // $place->street = $object->address->street;
        // $place->street_comment = $object->address->comment;
        // $place->lng = $object->address->mapPosition->coordinates[0];
        // $place->lat = $object->address->mapPosition->coordinates[1];
        $place->status = Place::STATUS_UPDATED;
        $place->category_id = 7;
        $place->city_id = 2;

        $place->save();
    }
}