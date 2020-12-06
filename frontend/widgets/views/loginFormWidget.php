<?php
 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;

?>

  <?php $form = ActiveForm::begin() ?>
		<?php ActiveForm::end() ?>

		<?php
		Modal::begin([
			'id' => 'login',
			'options' => [
				'class' => 'modal-dialog-centered'
			],
			'closeButton' => false,
		]);
		?>
		<span class="mod-close" data-dismiss="modal"><i class="ti-close"></i></span>
			<h4 class="modal-header-title">Surf <span class="theme-cl">City</span></h4>
			<?php $form = ActiveForm::begin([
				'id' => 'contact-form',
				// 'id' => 'login-form',
				// 'enableAjaxValidation' => true,
				'action' => ['/account/sign-in/login']
				]); ?>
			<div class="login-form">
				<form>
					<div class="row">
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
								<div class="input-with-icon">
									<?= $form->field($model, 'identity')->textInput(['autofocus' => true, 'placeholder' => 'Логин или Email']) ?>
									<!-- <i class="ti-user"></i> -->
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-6">
							<div class="form-group">
								<div class="input-with-icon">
									<?= $form->field($model, 'password')->passwordInput(['autofocus' => true, 'placeholder' => '******']) ?>
								</div>
								<!-- <i class="ti-email"></i> -->
							</div>
						</div>
						<div class="col-lg-6 col-md-6">
							<?= $form->field($model, 'rememberMe')->checkbox() ?>
						</div>
				</div>
					<div class="form-group">
						<?= Html::submitButton('Войти', ['class' => 'btn btn-md full-width pop-login', 'name' => 'contact-button']) ?>
					</div>
				</form>
			</div>
			<!-- <div class="modal-divider"><span>Или войдите через</span></div>
			<div class="social-login mb-3">
				<ul>
					<li><a href="#" class="btn connect-fb"><i class="ti-facebook"></i>Facebook</a></li>
					<li><a href="#" class="btn connect-twitter"><i class="ti-twitter"></i>Twitter</a></li>
				</ul>
			</div> -->
			<div class="text-center">
				<p class="mt-5"><?= Html::a(Yii::t('frontend', 'Lost password'), ['account/sign-in/request-password-reset']) ?></p>
			</div>
			<?php ActiveForm::end(); ?>
	<?php Modal::end(); ?>
