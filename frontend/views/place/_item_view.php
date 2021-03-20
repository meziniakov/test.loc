<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;
?>
					<!-- Single Listing -->
          <?php $img = $model->getImage(); ?>
						<div class="list-slide-box" data-name=<?= $model->name ?>>
							<div class="modern-list ml-2">
								<div class="list-badge now-open">Открыто</div>
								<div class="grid-category-thumb">
									<a href="<?= Url::to(['place/view', 'slug' => ($model->slug) ? $model->slug : $model->id]) ?>" class="overlay-cate"><?= Html::img($img->getUrl('358x229'), ['class' => 'img-responsive', 'alt' => $model->slug]) ?></a>
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
										<h4 class="lst-title"><?= Html::a($model->name, ['place/view', 'slug' => ($model->slug) ? $model->slug : $model->id]) ?><span class="veryfied-author"></span></h4>
									</div>
								</div>
								<div class="modern-list-content">
									<div class="listing-cat">
										<?php if (!empty($model->category->slug)) : ?>
											<?= Html::a("<i class='ti-briefcase bg-a'></i>" . $model->category->title, ['place/category', 'slug' => $model->category->slug], ['class' => 'cat-icon cl-1']) ?>
										<?php else : ?>
											<?= Html::a("<i class='ti-briefcase bg-a'></i>" . $model->type, ['place/category', 'slug' => $model->type], ['class' => 'cat-icon cl-1']) ?>
										<?php endif ?>
										<!-- <a href="search-listing.html" class="cat-icon cl-1"><i class="ti-briefcase bg-a"></i><?= $model->type ?></a> -->
										<!-- <span class="more-cat">+3</span> -->
									</div>
								</div>
							</div>
						</div>