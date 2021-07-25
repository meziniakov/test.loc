<?php
namespace backend\jobs;

use Yii;
use yii\helpers\Json;
use yii\web\UploadedFile;
use yii\base\BaseObject;
use common\models\City;
use common\models\Event;
use common\models\EventCategory;

class WikiJob extends BaseObject implements \yii\queue\JobInterface
{
    public $preview;
    public $city;

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
        $preview = $this->preview;
        $city_name = $this->city;

        if($city = City::findOne(['name' => $city_name])){
            $city->preview = $preview;
            $city->save(false);
        }
    }
}