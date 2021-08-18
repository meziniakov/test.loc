<section class="error-wrap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12">
                <h1>Ж/Д билеты</h1>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12">
                <script src="https://c45.travelpayouts.com/content?promo_id=1809&shmarker=323671&trs=133893&tab1=1&tab2=&tab3=&tab4=&tabDef=1&color_scheme=basic_white&hide_logo=true&hide_logo_tab=true&powered_by=false" charset="utf-8" async="true"></script>
            </div>
        </div>
    </div>
</section>
<section>
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12">
					<h2>Путешествуй по городам России 🎉</h2>
					<!-- <p>Top &amp; perfect 200+ location listings.</p> -->
]			</div>
		</div>
		<div class="row">
			<?php $i = 0; foreach ($cities as $city) : ?>
				<div class="col-lg-<?= ($i === 0) ? '8' : '4' ?> col-md-8">
					<a href="https://<?= $city['url'] ?>.trip2place.com/" class="img-wrap">
						<div class="img-wrap-content visible">
							<h4><?= $city->name ?></h4>
							<span>Мест: <?= $places->where(['city_id' => $city->id])->count() ?></span>
						</div>
						<div class="img-wrap-background" style="background-image: url(<?= $city->imageRico ? $city->imageRico->getUrl('560x359') : '' ?>);"></div>
					</a>
				</div>
			<?php $i++; endforeach ?>
		</div>
	</div>
</section>