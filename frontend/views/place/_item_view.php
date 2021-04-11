<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;
?>
					<!-- Single Listing -->
          <?php $img = $model->getImage(); ?>
						<div class="list-slide-box" data-name=<?= $model->title ?>>
							<div class="modern-list ml-2">
								<div class="list-badge now-open">Открыто</div>
								<div class="grid-category-thumb">
									<a href="<?= Url::to(['place/view', 'category' => $model->category->slug, 'slug' => $model->slug]) ?>" class="overlay-cate"><?= Html::img($img->getUrl('358x229'), ['class' => 'img-responsive', 'alt' => $img->alt]) ?></a>
									<!-- <div class="listing-price-info"> 
												<span class="pricetag">$25 - $65</span>
											</div> -->
									<div class="property_meta">
										<div class="list-rates">
											<i class="ti-star filled"></i>
											<i class="ti-star filled"></i>
											<i class="ti-star filled"></i>
											<i class="ti-star filled"></i>
											<i class="ti-star"></i>
											<!-- <a href="#" class="tl-review">(24 Reviews)</a> -->
										</div>
										<h4 class="lst-title"><?= Html::a($model->title, ['place/view', 'category' => $model->category->slug, 'slug' => $model->slug]) ?><span class="veryfied-author"></span></h4>
									</div>
								</div>
								<div class="modern-list-content">
									<?php if (!empty($model->category->slug)) : ?>
										<div class="listing-cat">
												<?= Html::a("<i class='{$model->category->icon} bg-a'></i>" . $model->category->title, ['place/category', 'slug' => $model->category->slug], ['class' => 'cat-icon cl-1']) ?>
											<!-- <span class="more-cat">+3</span> -->
										</div>
									<?php endif ?>
								</div>
							</div>
						</div>