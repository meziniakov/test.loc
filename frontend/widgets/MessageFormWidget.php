<?php
 
namespace frontend\widgets;
 
use yii\base\Widget;
use frontend\modules\account\models\MessageForm;
 
class MessageFormWidget extends Widget {
 
    public function run() {
            $model = new MessageForm();
            return $this->render('messageFormWidget', [
                'model' => $model,
            ]);
    }
 
}