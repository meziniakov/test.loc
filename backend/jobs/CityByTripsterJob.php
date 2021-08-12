<?php
namespace backend\jobs;

use Yii;
use yii\helpers\Json;
use yii\web\UploadedFile;
use yii\base\BaseObject;
use common\models\City;
use common\models\Event;
use common\models\EventCategory;

class CityByTripsterJob extends BaseObject implements \yii\queue\JobInterface
{
    public $city;
    public $pathinfo;

    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'alex290\yii2images\behaviors\ImageBehave',
            ],
        ];
    }

    public function execute($queue)
    {
        //пересохранить в нижнем регистре
        $result = $this->city;
        if($city = City::findOne(['name' => $result['name_ru']])){
            $city->save();
        } else {
            $city = new City();
            $city->name = $result['name_ru'];
            $city->url = str_replace('_', '-', $result['ascii_name']);
            $city->name_en = $result['name_en'];
            $city->iata = $result['iata'];
            $city->in_obj_phrase = $result['in_obj_phrase'];
            $city->from_obj_phrase = $result['from_obj_phrase'];
            $city->name_prepositional = $result['name_prepositional'];
            $city->ascii_name = $result['ascii_name'];
            $city->save(false);
            if (!empty($cover = $result['image']['cover'])) {
                $pathinfo = pathinfo($cover);
                $city->download($cover, $pathinfo);
                $city->uploadImage($pathinfo, $city->name);
            }
        }

    // {
    //     $result = $this->city;
    //     if($city = City::findOne(['name' => $result['name_ru']])){
    //         $city->name_en = $result['name_en'];
    //         $city->iata = $result['iata'];
    //         $city->in_obj_phrase = $result['in_obj_phrase'];
    //         $city->from_obj_phrase = $result['from_obj_phrase'];
    //         $city->name_prepositional = $result['name_prepositional'];
    //         $city->ascii_name = $result['ascii_name'];
    //         $city->save(false);
    //         if (!empty($cover = $result['image']['cover'])) {
    //             $pathinfo = pathinfo($cover);
    //             $city->download($cover, $pathinfo);
    //             $city->uploadImage($pathinfo, $city->name);
    //         }
    //     } else {
    //         $city = new City();
    //         $city->name = $result['name_ru'];
    //         $city->url = str_replace('_', '-', $result['ascii_name']);
    //         $city->name_en = $result['name_en'];
    //         $city->iata = $result['iata'];
    //         $city->in_obj_phrase = $result['in_obj_phrase'];
    //         $city->from_obj_phrase = $result['from_obj_phrase'];
    //         $city->name_prepositional = $result['name_prepositional'];
    //         $city->ascii_name = $result['ascii_name'];
    //         $city->save(false);
    //         if (!empty($cover = $result['image']['cover'])) {
    //             $pathinfo = pathinfo($cover);
    //             $city->download($cover, $pathinfo);
    //             $city->uploadImage($pathinfo, $city->name);
    //         }
    //     }
    // }
}