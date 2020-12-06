<?php
 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
 
Modal::begin([
    'header'=>'<h4>Message</h4>',
    'id'=>'message-modal',
]);
?>
 
    <p>Please fill out the following fields to login:</p>
 
<?php $form = ActiveForm::begin([
    'id' => 'message-form',
    'enableAjaxValidation' => true,
    'action' => ['account/default/ajax-message']
]);
echo $form->field($model, 'subject')->textInput();
echo $form->field($model, 'body')->textInput();
?>
 
<div>
</div>
<div class="form-group">
    <div class="text-right">
 
        <?php
        echo Html::button('Cancel', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']);
        echo Html::submitButton('Message', ['class' => 'btn btn-primary', 'name' => 'login-button']); 
        ?>
 
    </div>
</div>
 
<?php 
ActiveForm::end();
Modal::end();