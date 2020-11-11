<?php

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model frontend\models\ContactForm */

$this->title = Yii::t('frontend', 'Contact');
$this->params['breadcrumbs'][] = $this->title;
?>

			<!-- <div class="page-title">
				<div class="container">
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<h2 class="ipt-title">Contact Us</h2>
							<span class="ipn-subtitle">Lists of our all Popular agencies</span>							
						</div>
					</div>
				</div>
			</div> -->

			<section>
			
				<div class="container">
				
					<!-- row Start -->
					<div class="row">
					
						<div class="col-lg-7 col-md-7">
								<?php $form = ActiveForm::begin() ?>
							<div class="row">
								<div class="col-lg-6 col-md-6">
									<?= $form->field($model, 'name') ?>
								</div>
								
								<div class="col-lg-6 col-md-6">
									<?= $form->field($model, 'email') ?>
								</div>
							</div>
							
							<div class="form-group">
								<?= $form->field($model, 'subject') ?>
							</div>
							
							<div class="form-group">
									<?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>
							</div>
                            
              <?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
												'captchaAction' => '/site/captcha',
												'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
							]) ?>

							
							<div class="form-group">
								<?= Html::submitButton(Yii::t('frontend', 'Send'), ['class' => 'btn btn-theme']) ?>
							</div>
						</div>

            <?php ActiveForm::end() ?>

						<div class="col-lg-5 col-md-5">
							<div class="contact-info">
								
								<h2>Контакты</h2>
								<!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p> -->
								
								<!-- <div class="cn-info-detail">
									<div class="cn-info-icon">
										<i class="ti-home"></i>
									</div>
									<div class="cn-info-content">
										<h4 class="cn-info-title">Reach Us</h4>
										2512, New Market,<br>Eliza Road, Sincher 80 CA,<br>Canada, USA
									</div>
								</div> -->
								
								<div class="cn-info-detail">
									<div class="cn-info-icon">
										<i class="ti-email"></i>
									</div>
									<div class="cn-info-content">
										<h4 class="cn-info-title">Email</h4>
										info@test.loc
									</div>
								</div>
								
								<!-- <div class="cn-info-detail">
									<div class="cn-info-icon">
										<i class="ti-mobile"></i>
									</div>
									<div class="cn-info-content">
										<h4 class="cn-info-title">Call Us</h4>
										(41) 123 521 458<br>+91 235 548 7548
									</div>
								</div> -->
								
							</div>
						</div>
						
					</div>
					<!-- /row -->		
					
				</div>
						
			</section>