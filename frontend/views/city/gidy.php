<?php
/* @var $this yii\web\View */

use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ListView;
use common\models\City;

?>
<?php echo $this->render('_menu', [
				'city' => $city,
        'title' => $this->title
			]); ?>

<section class="gray">
				<div class="container">
					
					<div class="row">
												
						<!-- Single List Start -->
						<div class="col-lg-12 col-md-12 col-sm-12" style="display: contents;">
							
							<!--  Single Listing -->
							<?php foreach($activities as $activity):?>
							<div class="col-lg-4 col-md-6 col-sm-12">
							<script type="application/ld+json">{
								"@context": "http://schema.org",
								"@type": "Event",
								"eventAttendanceMode": "https://schema.org/OfflineEventAttendanceMode",
								"eventStatus": "http://schema.org/EventScheduled",
								"name": "<?= $activity->title ?>",
								"url": "<?= $activity->url ?>",
								"image": "<?= $activity->cover_image?>",
								"description": "<?= $activity->tagline ?>",
								"organizer": [
									{
										"@type": "Organization",
										"name": "<?= $activity->guide->first_name ?>",
										"url": "<?= $activity->guide->url ?>"
									}
								],
								"performer": [
									{
										"@type": "PerformingGroup",
										"name": "<?= $activity->guide->first_name ?>",
										"url": "<?= $activity->guide->url ?>"
									}
								],
								"location": [
									{
										"@type": "Place",
										"name": "<?= $activity->city->name_ru ?>",
										"url": "<?= $activity->city->url ?>",
										"address": [
											{
												"@type": "PostalAddress",
												"addressCountry": [
													{
														"@type": "Country",
														"name": "<?= $activity->city->country->name_ru ?>"
													}
												]
											}
										]
									}
								],
								"offers": [
									{
										"@type": "Offer",
										"availability": "https://schema.org/InStock",
										"price": [
											"<?= $activity->price->value ?>"
										],
										"priceCurrency": "<?= $activity->price->currency ?>",
										"url": "<?= $activity->url ?>"
									}
								]
							}</script>
							<div class="property_item classical-list">
								<div class="image">
									<a href="<?= $activity->url?>" title="Экскурсия «<?= $activity->title ?>»" class="listing-thumb">
										<img src="<?= $activity->cover_image?>" alt="Город <?= $activity->city->name_ru . '. ' . $activity->city->country->name_ru?>" class="img-responsive">
									</a>
									<div class="listing-price-info"> 
										<span class="pricetag"><?= $activity->price->value?> ₽</span>
									</div>
									<span class="list-rate good"><?= $activity->rating?></span>									
								</div>
								
								<div class="proerty_content">
									<div class="author-avater">
										<img src="<?= $activity->guide->avatar->medium?>" class="author-avater-img" title="<?= $activity->guide->first_name . ' — гид ' . $activity->city->in_obj_phrase?>" alt="<?= $activity->guide->first_name . ' — гид ' . $activity->city->in_obj_phrase?>">
									</div>
									<div class="proerty_text">
									  <h3 class="captlize"><a href="<?= $activity->url ?>"><?= $activity->title ?></a><span class="veryfied-author"></span></h3>
									</div>
									<p class="property_add"><?= $activity->tagline?></p>
									<!-- <div class="property_meta"> 
									  <div class="list-fx-features">
											<div class="listing-card-info-icon">
												<span class="inc-fleat inc-add"><? $activity->city->name_ru?></span>
											</div>
											<div class="listing-card-info-icon">
												<span class="inc-fleat inc-call">+91 2356 548 958</span>
											</div>
										</div>  
									</div> -->
								</div>
								
								<!-- <div class="listing-footer-info">
									<div class="listing-cat">
										<a href="search-listing.html" class="cat-icon cl-1"><i class="ti-briefcase bg-a"></i></a>
										<span class="cat-icon cl-1"><i class="lni-users"></i></span>
									</div>
									<span class="place-status"></span>
								</div> -->
								
							</div>
						</div>
						<?php endforeach?>

						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12 col-sm-12 mt-3">
							<div class="text-center">
								
								<div class="spinner-grow text-danger" role="status">
								  <span class="sr-only">Loading...</span>
								</div>
								<div class="spinner-grow text-warning" role="status">
								  <span class="sr-only">Loading...</span>
								</div>
								<div class="spinner-grow text-success" role="status">
								  <span class="sr-only">Loading...</span>
								</div>
								
							</div>
						</div>	
					</div>
					
				</div>
			</section>
<div class="clearfix"></div>