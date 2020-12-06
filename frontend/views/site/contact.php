<?php

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model frontend\models\ContactForm */

$this->title = Yii::t('frontend', 'Contact');
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-title">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12">
				<h2 class="ipt-title">Contact Us</h2>
				<span class="ipn-subtitle">Lists of our all Popular agencies</span>
			</div>
		</div>
	</div>
</div>

<section>

	<div class="container">

		<div class="row">

			<div class="col-lg-4 col-md-4 col-sm-12">
				<div class="contact-box">
				<a href="#" data-toggle="modal" data-target="#w1" class="rt-log">
					<i class="ti-shopping-cart theme-cl"></i>
					<h4>Напишите нам</h4>
					<p>sales@rikadahelp.co.uk</p>
					<span>+01 215 245 6258</span>
					</a>
				</div>
			</div>

			<div class="col-lg-4 col-md-4 col-sm-12">
				<div class="contact-box">
					<i class="ti-user theme-cl"></i>
					<h4>Contact Sales</h4>
					<p>sales@rikadahelp.co.uk</p>
					<span>+01 215 245 6258</span>
				</div>
			</div>

			<div class="col-lg-4 col-md-4 col-sm-12">
				<div class="contact-box">
					<i class="ti-comment-alt theme-cl"></i>
					<h4>Start Live Chat</h4>
					<span>+01 215 245 6258</span>
					<span class="live-chat">Live Chat</span>
				</div>
			</div>

		</div>
		<?php $form = ActiveForm::begin() ?>
		<?php ActiveForm::end() ?>
	</div>

	</section>
		<?php
		Modal::begin([
			'id' => 'w10',
			'options' => [
				'class' => 'modal-dialog-centered'
			],
			'closeButton' => false,
		]);
		?>
		<span class="mod-close" data-dismiss="modal"><i class="ti-close"></i></span>
			<h4 class="modal-header-title">Surf <span class="theme-cl">City</span></h4>
			<?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
			<div class="login-form">
				<form>
					<div class="row">
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
								<div class="input-with-icon">
									<?= $form->field($model, 'name')->textInput(['autofocus' => true, 'placeholder' => 'Имя']) ?>
									<i class="ti-user"></i>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
								<div class="input-with-icon">
									<?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => 'Email']) ?>
									<i class="ti-email"></i>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="input-with-icon">
							<?= $form->field($model, 'subject')->textInput(['autofocus' => true, 'placeholder' => 'Тема']) ?>
							<i class="ti-message"></i>
						</div>
					</div>
					<div class="form-group">
						<div class="input-with-icon">
							<?= $form->field($model, 'body')->textArea(['rows' => 8, 'placeholder' => 'Сообщение']) ?>
							<i class="ti-message"></i>
						</div>
					</div>
					<div class="form-group">
							<?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
								'captchaAction' => '/site/captcha',
								'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
							]) ?>
					</div>
					<div class="form-group">
						<?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
					</div>
				</form>
			</div>
			<div class="modal-divider"><span>Или войдите через</span></div>
			<div class="social-login mb-3">
				<ul>
					<li><a href="#" class="btn connect-fb"><i class="ti-facebook"></i>Facebook</a></li>
					<li><a href="#" class="btn connect-twitter"><i class="ti-twitter"></i>Twitter</a></li>
				</ul>
			</div>
			<div class="text-center">
				<p class="mt-5"><a href="#" class="link">Забыли пароль?</a></p>
			</div>
			<?php ActiveForm::end(); ?>
	<?php Modal::end(); ?>
