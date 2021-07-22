<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = "Города";
$this->params['breadcrumbs'][] = $this->title;

$firstLetter = [];
foreach ($model as $city) {
    $firstLetter[mb_substr($city->name, 0, 1, "UTF-8")][] = [
        'name' => $city->name,
        'url' => $city->url
    ];
}
ksort($firstLetter);
?>

<section class="error-wrap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-12">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>Выберите город</h2>
                    </div>
                    <?php foreach ($firstLetter as $letter => $cities) : ?>
                        <div class="col-lg-3 col-md-6 col-sm-12 relative bi-avoid mb-5">
                            <div class="text-gold-500 font-semibold text-lg"><?= $letter; ?></div>
                            <ul class="mb-4 list-none p-0 mt-0">
                                <?php foreach ($cities as $city) : ?>
                                    <li class="py-2"><a href="https://<?= $city['url'] ?>.trip2place.com/" target="_self" class="cursor-pointer no-underline focus:shadow-focus border-0 border-b border-solid text-blue-500 border-blue-500 visited:text-blue-500 hover:text-black-500 hover:border-black-300"><?= $city['name'] ?></a></li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
</section>