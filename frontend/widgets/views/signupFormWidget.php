<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\captcha\Captcha;

?>

<?php $form = ActiveForm::begin() ?>
<?php ActiveForm::end() ?>

<?php
Modal::begin([
  'id' => 'signup',
  'options' => [
    'class' => 'modal-dialog-centered'
  ],
  'closeButton' => false,
]);
?>
<span class="mod-close" data-dismiss="modal"><i class="ti-close"></i></span>
<h4 class="modal-header-title">Surf <span class="theme-cl">City</span></h4>
<?php $form = ActiveForm::begin([
  'id' => 'signup-form',
  // 'id' => 'login-form',
  // 'enableAjaxValidation' => true,
  'action' => ['/account/sign-in/signup']
]); ?>
<div class="signup-form">
  <form>
    <div class="row">
      <div class="col-lg-6 col-md-6">
        <div class="form-group">
          <div class="input-with-icon">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
            <i class="ti-user"></i>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6">
        <div class="form-group">
          <div class="input-with-icon">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            <i class="ti-email"></i>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6">
        <div class="form-group">
          <div class="input-with-icon">
            <?= $form->field($model, 'password')->passwordInput(['autofocus' => true, 'placeholder' => '******']) ?>
            <i class="ti-unlock"></i>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6">
        <div class="form-group">
          <div class="input-with-icon">
            <?= $form->field($model, 'password_confirm')->passwordInput(['maxlength' => true, 'placeholder' => 'Повторите пароль']) ?>
            <i class="ti-unlock"></i>
          </div>
        </div>
      </div>
    </div>
    <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
      'captchaAction' => '/site/captcha',
      'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
    ]) ?>

    <div class="form-group">
      <?= Html::submitButton('Регистрация', ['class' => 'btn btn-md full-width pop-login', 'name' => 'contact-button']) ?>
    </div>
    <div class="text-center">
      <p class="mt-5"><i class="ti-user mr-1"></i>Уже есть аккаунт? <?= Html::a(Yii::t('frontend', 'Войдите'), '#', ['data-toggle' => 'modal', 'data-target' => '#login']) ?></p>
    </div>
  </form>
</div>

<?php ActiveForm::end(); ?>
<?php Modal::end(); ?>