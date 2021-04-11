
<?php foreach ($listing as $place) : ?>
					<?php $img = $place->getImage(); ?>
					<!-- Single Listing -->
					<div class="col-lg-6 col-md-12 col-sm-12">
						<div class="list-slide-box" data-name=<?= $place->title ?>>
							<div class="modern-list ml-2">
								<div class="list-badge now-open">Открыто</div>
								<div class="grid-category-thumb">
									<a href="<?= Url::to(['place/view', 'slug' => ($place->slug) ? $place->slug : $place->id]) ?>" class="overlay-cate"><?= Html::img($img->getUrl('358x229'), ['class' => 'img-responsive', 'alt' => $place->slug]) ?></a>
									<!-- <a href="search-listing.html" class="overlay-cate"><img src="/reveal/img/f389baedd25b0b8e84ba403877d6ebdf.jpg" class="img-responsive" alt="" /></a> -->
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
										<h4 class="lst-title"><?= Html::a($place->title, ['place/view', 'slug' => ($place->slug) ? $place->slug : $place->id]) ?><span class="veryfied-author"></span></h4>
									</div>
								</div>
								<div class="modern-list-content">
									<div class="listing-cat">
										<?php if (!empty($place->category->slug)) : ?>
											<?= Html::a("<i class='ti-briefcase bg-a'></i>" . $place->category->title, ['place/category', 'slug' => $place->category->slug], ['class' => 'cat-icon cl-1']) ?>
										<?php else : ?>
											<?= Html::a("<i class='ti-briefcase bg-a'></i>" . $place->type, ['place/category', 'slug' => $place->type], ['class' => 'cat-icon cl-1']) ?>
										<?php endif ?>
										<!-- <a href="search-listing.html" class="cat-icon cl-1"><i class="ti-briefcase bg-a"></i><?= $place->type ?></a> -->
										<span class="more-cat">+3</span>
									</div>
									<!-- <div class="author-avater">
												<img src="https://via.placeholder.com/400x400" class="author-avater-img" alt="">
											</div> -->
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
				<div class="col-md-12 col-sm-12 mt-3">
					<div class="text-center">
						<?= LinkPager::widget([
							'pagination' => $pages,
						]); ?>
						<!-- <div class="spinner-grow text-danger" role="status">
							<span class="sr-only">Loading...</span>
						</div>
						<div class="spinner-grow text-warning" role="status">
							<span class="sr-only">Loading...</span>
						</div>
						<div class="spinner-grow text-success" role="status">
							<span class="sr-only">Loading...</span>
						</div> -->

					</div>
				</div>