<?php
$this->registerCssFile('/reveal/css/cities.css');

$firstLetter = [];
  foreach ($cities as $city) {
    $firstLetter[mb_substr($city->name,0,1,"UTF-8")][] = [
      'name' => $city->name,
      'url' => $city->url
    ];
  }
ksort($firstLetter);
?>

<div class="col-count-2 col-count-6">
  <?php foreach($firstLetter as $letter => $cities):?>
  <div class="relative bi-avoid mb-5">
    <div class="text-gold-500 font-semibold text-lg"><?= $letter;?></div>
    <ul class="mb-4 list-none p-0 mt-0">
      <?php foreach($cities as $city):?>
      <li class="py-2"><a href="https://trip2place.com/<?= $city['url']?>" target="_self" class="cursor-pointer no-underline focus:shadow-focus border-0 border-b border-solid text-blue-500 border-blue-500 visited:text-blue-500 hover:text-black-500 hover:border-black-300"><?= $city['name']?></a></li>
      <?php endforeach?>
    </ul>
  </div>
  <?php endforeach ?>
</div>