<?php
 
namespace frontend\widgets;
 
use Yii;
use yii\base\Widget;
use common\models\City;

class ChooseCityWidget extends Widget
{
    public function run() {
            $model = City::find()->published()->all();
            return $this->render('chooseCityWidget', [
                'model' => $model,
            ]);
    }
}