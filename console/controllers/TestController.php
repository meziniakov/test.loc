<?php

namespace console\controllers;

use backend\jobs\CreatePlaceJob;
use backend\jobs\UpdatePlaceJob;
use common\models\Place;
use Yii;
use yii\console\Controller;
use yii\helpers\Console;
use yii\helpers\Json;

class TestController extends Controller
{
    public function actionTest()
    {
        // $path = '/var/www/yii2zif/test.loc/storage/json/events/museums.json';
        $path = '/var/www/surf-city/storage/theme/museums.json';
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
    }
}