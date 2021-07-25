<?php

namespace frontend\components;

use yii;
use yii\base\Component;
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\City;

class CityComponent extends Component
{
  public function isCity() {
    return City::find()->where('url = :url', [':url' => Yii::$app->params['city']])->published()->one();
  }
}