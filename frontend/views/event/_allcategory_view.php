<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;
?>
						<div class="list-slide-box" data-name=<?= $model->title ?>>
							<div class="modern-list ml-2">
								<?php if(isset($model->schedule)):?>
								<div class="list-badge now-open">Открыто</div>
								<?php endif?>
								<div class="grid-category-thumb">
								<?php if(isset($model->city) && isset($model->category)):?>
									<a href="<?= Url::to(['event/view', 'category' => $model->category->slug, 'city' => $model->city->url, 'slug' => $model->slug]) ?>" class="overlay-cate"><?= Html::img($model->imageRico->getUrl('358x229'), ['class' => 'img-responsive', 'alt' => $model->imageRico->alt]) ?></a>
								<?php else :?>
									<a href="<?= Url::to(['event/view', 'category' => $model->category->slug, 'slug' => $model->slug]) ?>" class="overlay-cate"><?= Html::img($model->imageRico->getUrl('358x229'), ['class' => 'img-responsive', 'alt' => $model->imageRico->alt]) ?></a>
									<?php endif ?>
									<div class="property_meta">
										<div class="list-rates">
											<i class="ti-star filled"></i>
											<i class="ti-star filled"></i>
											<i class="ti-star filled"></i>
											<i class="ti-star filled"></i>
											<i class="ti-star"></i>
										</div>
										<?php if(isset($model->city) && isset($model->category)):?>
											<h4 class="lst-title"><?= Html::a($model->title, ['event/view', 'category' => $model->category->slug, 'city' => $model->city->url,'slug' => $model->slug]) ?></h4>
								<?php else :?>
									<h4 class="lst-title"><?= Html::a($model->title, ['event/view', 'category' => $model->category->slug, 'slug' => $model->slug]) ?></h4>
									<?php endif ?>
									</div>
								</div>
								<div class="modern-list-content">
									<?php if (!empty($model->category->slug)) : ?>
										<div class="listing-cat">
												<?= Html::a("<i class='{$model->category->icon} bg-a'></i>" . $model->category->title, ['event/category', 'slug' => $model->category->slug], ['class' => 'cat-icon cl-1']) ?>
										</div>
									<?php endif ?>
								</div>
							</div>
						</div>