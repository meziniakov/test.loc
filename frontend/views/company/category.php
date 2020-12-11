<?php

// $this->registerJsFile("/reveal/js/map.js", 
// $options = ['depends' => ['frontend\assets\AppAsset']]);

use yii\bootstrap\Html;

$this->registerJsFile(
  "/reveal/js/ymap.js",
  $options = ['depends' => ['frontend\assets\AppAsset']]
);
?>
<div class="fs-container half-map">

  <div class="fs-left-map-box">
    <div class="home-map fl-wrap">
      <div class="map-container fw-map">
        <div id="map-main"></div>
      </div>
    </div>
  </div>

  <div class="fs-inner-container">
    <div class="fs-content">

      <div class="row">

        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="form-group">
            <div class="input-with-icon">
              <input type="text" class="form-control" placeholder="Keyword...">
              <i class="ti-search theme-cl"></i>
            </div>
          </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="form-group">
            <div class="input-with-icon">
              <input type="text" class="form-control" placeholder="Where...">
              <i class="ti-target theme-cl"></i>
            </div>
          </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="form-group">
            <div class="input-with-icon">
              <select id="choose-city" class="form-control">
                <option value="">&nbsp;</option>
                <option value="1">Los Angeles, CA</option>
                <option value="2">New York City, NY</option>
                <option value="3">Chicago, IL</option>
                <option value="4">Houston, TX</option>
                <option value="5">Philadelphia, PA</option>
                <option value="6">San Antonio, TX</option>
                <option value="7">San Jose, CA</option>
              </select>
              <i class="ti-briefcase theme-cl"></i>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
          <div class="form-group">
            <div class="input-with-icon">
              <select id="list-category" class="form-control">
                <option value="">&nbsp;</option>
                <option value="1">Spa & Bars</option>
                <option value="2">Restaurants</option>
                <option value="3">Hotels</option>
                <option value="4">Educations</option>
                <option value="5">Business</option>
                <option value="6">Retail & Shops</option>
                <option value="7">Garage & Services</option>
              </select>
              <i class="ti-layers theme-cl"></i>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group" id="module">
            <a role="button" class="collapsed" data-toggle="collapse" href="#advance-search" aria-expanded="false" aria-controls="advance-search"></a>
          </div>
        </div>
        <div class="collapse" id="advance-search" aria-expanded="false" role="banner">
          <div class="col-lg-12 col-md-12 col-sm-12">
            <h4>Amenities & Features</h4>
            <ul class="no-ul-list third-row">
              <li>
                <input id="a-1" class="checkbox-custom" name="a-1" type="checkbox">
                <label for="a-1" class="checkbox-custom-label">Air Condition</label>
              </li>
              <li>
                <input id="a-2" class="checkbox-custom" name="a-2" type="checkbox">
                <label for="a-2" class="checkbox-custom-label">Bedding</label>
              </li>
              <li>
                <input id="a-3" class="checkbox-custom" name="a-3" type="checkbox">
                <label for="a-3" class="checkbox-custom-label">Heating</label>
              </li>
              <li>
                <input id="a-4" class="checkbox-custom" name="a-4" type="checkbox">
                <label for="a-4" class="checkbox-custom-label">Internet</label>
              </li>
              <li>
                <input id="a-5" class="checkbox-custom" name="a-5" type="checkbox">
                <label for="a-5" class="checkbox-custom-label">Microwave</label>
              </li>
              <li>
                <input id="a-6" class="checkbox-custom" name="a-6" type="checkbox">
                <label for="a-6" class="checkbox-custom-label">Smoking Allow</label>
              </li>
              <li>
                <input id="a-7" class="checkbox-custom" name="a-7" type="checkbox">
                <label for="a-7" class="checkbox-custom-label">Terrace</label>
              </li>
              <li>
                <input id="a-8" class="checkbox-custom" name="a-8" type="checkbox">
                <label for="a-8" class="checkbox-custom-label">Balcony</label>
              </li>
              <li>
                <input id="a-9" class="checkbox-custom" name="a-9" type="checkbox">
                <label for="a-9" class="checkbox-custom-label">Icon</label>
              </li>
              <li>
                <input id="a-10" class="checkbox-custom" name="a-10" type="checkbox">
                <label for="a-10" class="checkbox-custom-label">Wi-Fi</label>
              </li>
              <li>
                <input id="a-11" class="checkbox-custom" name="a-11" type="checkbox">
                <label for="a-11" class="checkbox-custom-label">Beach</label>
              </li>
              <li>
                <input id="a-12" class="checkbox-custom" name="a-12" type="checkbox">
                <label for="a-12" class="checkbox-custom-label">Parking</label>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!--- Filter List -->
      <div class="row">
        <!-- Filter Result -->
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="shorting-wrap">
            <h5 class="shorting-title">507 Results</h5>
            <div class="shorting-right">
              <label>Short By:</label>
              <div class="dropdown show">
                <a class="btn btn-filter dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="selection">Most Rated</span>
                </a>
                <div class="drp-select dropdown-menu">
                  <a class="dropdown-item" href="JavaScript:Void(0);">Most Rated</a>
                  <a class="dropdown-item" href="JavaScript:Void(0);">Most Viewd</a>
                  <a class="dropdown-item" href="JavaScript:Void(0);">News Listings</a>
                  <a class="dropdown-item" href="JavaScript:Void(0);">High Rated</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--- All List -->
      <div class="row">
      <pre>
      </pre>
        <?php foreach ($listing as $company) : ?>
          <?php // var_dump($company); die?>

          <!-- Single Listing -->
          <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="list-slide-box" data-name=<?= $company->name ?>>
              <div class="modern-list ml-2">
                <div class="list-badge now-open">Открыто</div>
                <div class="grid-category-thumb">
                  <a href="search-listing.html" class="overlay-cate"><img src="/reveal/img/f389baedd25b0b8e84ba403877d6ebdf.jpg" class="img-responsive" alt="" /></a>
                  <div class="listing-price-info">
                    <span class="pricetag">$25 - $65</span>
                  </div>
                  <div class="property_meta">
                    <div class="list-rates">
                      <i class="ti-star filled"></i>
                      <i class="ti-star filled"></i>
                      <i class="ti-star filled"></i>
                      <i class="ti-star filled"></i>
                      <i class="ti-star"></i>
                      <a href="#" class="tl-review">(24 Reviews)</a>
                    </div>
                    <h4 class="lst-title"><?= Html::a($company->name, ['company/view', 'slug' => $company->slug]) ?><span class="veryfied-author"></span></h4>
                  </div>
                </div>
                <div class="modern-list-content">
                  <div class="listing-cat">
                    <a href="search-listing.html" class="cat-icon cl-1"><i class="ti-briefcase bg-a"></i><?= $company->type ?></a>
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
  </div>
</div>
<div class="clearfix"></div>
<!-- Map -->
<script src="https://api-maps.yandex.ru/2.1/?apikey=23968611-fd0e-4aea-9982-22f92e32a9bf&lang=ru_RU" type="text/javascript"></script>