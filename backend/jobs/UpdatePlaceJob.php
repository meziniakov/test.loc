<?php
namespace backend\jobs;

use yii\helpers\Json;
use yii\base\BaseObject;
use common\models\Place;
use common\models\PlaceCategory;
use common\models\City;

class UpdatePlaceJob extends BaseObject implements \yii\queue\JobInterface
{
    public $object;
    public $place;

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
        $place = $this->place;

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