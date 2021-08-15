<?php
namespace backend\jobs;

use yii\base\BaseObject;
use common\models\Place;

class UpdatePlaceJob extends BaseObject implements \yii\queue\JobInterface
{
    public $object;
    public $place;

    public function execute($queue)
    {
        $object = $this->object;
        $place = $this->place;
        $place->title = $object->name;
        $place->src_id = $object->id;
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
    }
}