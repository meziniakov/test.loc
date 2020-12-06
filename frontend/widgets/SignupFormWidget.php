<?php
 
namespace frontend\widgets;
 
use Yii;
use yii\base\Widget;
use frontend\modules\account\models\SignupForm;
 
class SignupFormWidget extends Widget {
 
    public function run() {
            $model = new SignupForm();
            return $this->render('signupFormWidget', [
                'model' => $model,
            ]);
    }
 
}