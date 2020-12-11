<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

$this->registerCssFile(
    "/static/css/LineIcons.css");

/* @var $this yii\web\View */
/* @var $model common\models\CompanyCategory */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="article-category-form">

    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>
        <?php
    // $model->klass = 0;
    $icon = [
'lni-500px','lni-add-files','lni-alarm-clock','lni-alarm','lni-airbnb','lni-adobe','lni-amazon-pay','lni-amazon','lni-amex','lni-anchor','lni-amazon-original','lni-android-original','lni-android','lni-angellist','lni-angle-double-down','lni-angle-double-left','lni-angle-double-right','lni-angle-double-up','lni-angular','lni-apartment','lni-app-store','lni-apple-pay','lni-apple','lni-archive','lni-arrow-down-circle','lni-arrow-left-circle','lni-arrow-left','lni-arrow-right-circle','lni-arrow-right','lni-arrow-top-left','lni-arrow-top-right','lni-arrow-up-circle','lni-arrow-up','lni-arrows-horizontal','lni-arrows-vertical','lni-atlassian','lni-aws','lni-arrow-down','lni-ambulance','lni-agenda','lni-backward','lni-baloon','lni-ban','lni-bar-chart','lni-behance-original','lni-bitbucket','lni-bitcoin','lni-blackboard','lni-blogger','lni-bluetooth','lni-bold','lni-bolt-alt','lni-bolt','lni-book','lni-bookmark-alt','lni-bookmark','lni-bootstrap','lni-bricks','lni-bridge','lni-briefcase','lni-brush-alt','lni-brush','lni-bubble','lni-bug','lni-bulb','lni-bullhorn','lni-burger','lni-bus','lni-cake','lni-calculator','lni-calendar','lni-camera','lni-candy-cane','lni-candy','lni-capsule','lni-car-alt','lni-car','lni-caravan','lni-cart-full','lni-cart','lni-certificate','lni-checkbox','lni-checkmark-circle','lni-checkmark','lni-chef-hat','lni-chevron-down-circle','lni-chevron-down','lni-chevron-left-circle','lni-chevron-left','lni-chevron-right-circle','lni-chevron-right','lni-chevron-up-circle','lni-chevron-up','lni-chrome','lni-circle-minus','lni-circle-plus','lni-clipboard','lni-close','lni-cloud-check','lni-cloud-download','lni-cloud-network','lni-cloud-sync','lni-cloud-upload','lni-cloud','lni-cloudy-sun','lni-code-alt','lni-code','lni-codepen','lni-coffee-cup','lni-cog','lni-cogs','lni-coin','lni-comments-alt','lni-comments-reply','lni-comments','lni-compass','lni-construction-hammer','lni-construction','lni-consulting','lni-control-panel','lni-cpanel','lni-creative-commons','lni-credit-cards','lni-crop','lni-cross-circle','lni-crown','lni-css3','lni-cup','lni-customer','lni-cut','lni-dashboard','lni-database','lni-delivery','lni-dev','lni-diamond-alt','lni-diamond','lni-diners-club','lni-dinner','lni-direction-alt','lni-direction-ltr','lni-direction-rtl','lni-direction','lni-discord','lni-discover','lni-display-alt','lni-display','lni-docker','lni-dollar','lni-domain','lni-download','lni-dribbble','lni-drop','lni-dropbox-original','lni-dropbox','lni-drupal-original','lni-drupal','lni-dumbbell','lni-edge','lni-emoji-cool','lni-emoji-friendly','lni-emoji-happy','lni-emoji-sad','lni-emoji-smile','lni-emoji-speechless','lni-emoji-suspect','lni-emoji-tounge','lni-empty-file','lni-enter','lni-envato','lni-envelope','lni-eraser','lni-euro','lni-exit-down','lni-exit-up','lni-exit','lni-eye','lni-facebook-filled','lni-facebook-messenger','lni-facebook-original','lni-facebook-oval','lni-facebook','lni-figma','lni-files','lni-firefox-original','lni-firefox','lni-fireworks','lni-first-aid','lni-flag-alt','lni-flag','lni-flags','lni-flickr','lni-basketball','lni-behance','lni-forward','lni-frame-expand','lni-flower','lni-full-screen','lni-funnel','lni-gallery','lni-game','lni-gift','lni-git','lni-github-original','lni-github','lni-goodreads','lni-google-drive','lni-google-pay','lni-fresh-juice','lni-folder','lni-bi-cycle','lni-graph','lni-grid-alt','lni-grid','lni-google-wallet','lni-grow','lni-hammer','lni-hand','lni-handshake','lni-harddrive','lni-headphone-alt','lni-headphone','lni-heart-filled','lni-heart-monitor','lni-heart','lni-helicopter','lni-helmet','lni-help','lni-highlight-alt','lni-highlight','lni-home','lni-hospital','lni-hourglass','lni-html5','lni-image','lni-inbox','lni-indent-decrease','lni-indent-increase','lni-infinite','lni-information','lni-instagram-filled','lni-instagram-original','lni-instagram','lni-invention','lni-graduation','lni-invest-monitor','lni-island','lni-italic','lni-java','lni-javascript','lni-jcb','lni-joomla-original','lni-joomla','lni-jsfiddle','lni-juice','lni-key','lni-keyboard','lni-keyword-research','lni-hacker-news','lni-google','lni-laravel','lni-layers','lni-layout','lni-leaf','lni-library','lni-licencse','lni-life-ring','lni-line-dashed','lni-line-dotted','lni-line-double','lni-line-spacing','lni-line','lni-lineicons-alt','lni-lineicons','lni-link','lni-linkedin-original','lni-linkedin','lni-list','lni-lock-alt','lni-lock','lni-magnet','lni-magnifier','lni-mailchimp','lni-map-marker','lni-map','lni-mashroom','lni-mastercard','lni-medall-alt','lni-medall','lni-medium','lni-laptop','lni-investment','lni-laptop-phone','lni-megento','lni-mic','lni-microphone','lni-menu','lni-microscope','lni-money-location','lni-minus','lni-mobile','lni-more-alt','lni-mouse','lni-move','lni-music','lni-network','lni-night','lni-nodejs-alt','lni-nodejs','lni-notepad','lni-npm','lni-offer','lni-opera','lni-package','lni-page-break','lni-pagination','lni-paint-bucket','lni-paint-roller','lni-pallet','lni-paperclip','lni-more','lni-pause','lni-paypal-original','lni-microsoft','lni-money-protection','lni-pencil','lni-paypal','lni-pencil-alt','lni-patreon','lni-phone-set','lni-phone','lni-pin','lni-pinterest','lni-pie-chart','lni-pilcrow','lni-plane','lni-play','lni-plug','lni-plus','lni-pointer-down','lni-pointer-left','lni-pointer-right','lni-pointer-up','lni-play-store','lni-pizza','lni-postcard','lni-pound','lni-power-switch','lni-printer','lni-producthunt','lni-protection','lni-pulse','lni-pyramids','lni-python','lni-pointer','lni-popup','lni-quotation','lni-radio-button','lni-rain','lni-quora','lni-react','lni-question-circle','lni-php','lni-reddit','lni-reload','lni-restaurant','lni-road','lni-rocket','lni-rss-feed','lni-ruler-alt','lni-ruler-pencil','lni-ruler','lni-rupee','lni-save','lni-school-bench-alt','lni-school-bench','lni-scooter','lni-scroll-down','lni-search-alt','lni-search','lni-select','lni-seo','lni-service','lni-share-alt','lni-share','lni-shield','lni-shift-left','lni-shift-right','lni-ship','lni-shopify','lni-shopping-basket','lni-shortcode','lni-shovel','lni-shuffle','lni-signal','lni-sketch','lni-skipping-rope','lni-skype','lni-slack','lni-slice','lni-slideshare','lni-slim','lni-reply','lni-sort-alpha-asc','lni-remove-file','lni-sort-amount-dsc','lni-sort-amount-asc','lni-soundcloud','lni-souncloud-original','lni-spiner-solid','lni-revenue','lni-spinner','lni-spellcheck','lni-spotify','lni-spray','lni-sprout','lni-snapchat','lni-stamp','lni-star-empty','lni-star-filled','lni-star-half','lni-star','lni-stats-down','lni-spinner-arrow','lni-steam','lni-stackoverflow','lni-stop','lni-strikethrough','lni-sthethoscope','lni-stumbleupon','lni-sun','lni-support','lni-surf-board','lni-swift','lni-syringe','lni-tab','lni-tag','lni-target-customer','lni-target-revenue','lni-target','lni-taxi','lni-stats-up','lni-telegram-original','lni-telegram','lni-text-align-center','lni-text-align-justify','lni-text-align-left','lni-text-format-remove','lni-text-align-right','lni-text-format','lni-thought','lni-thumbs-down','lni-thumbs-up','lni-thunder-alt','lni-thunder','lni-ticket-alt','lni-ticket','lni-timer','lni-train-alt','lni-train','lni-trash','lni-travel','lni-tree','lni-trees','lni-trello','lni-trowel','lni-tshirt','lni-tumblr','lni-twitch','lni-twitter-filled','lni-twitter-original','lni-twitter','lni-ubuntu','lni-underline','lni-unlink','lni-unlock','lni-upload','lni-user','lni-users','lni-ux','lni-vector','lni-video','lni-vimeo','lni-visa','lni-vk','lni-volume-high','lni-volume-low','lni-volume-medium','lni-volume-mute','lni-volume','lni-wallet','lni-warning','lni-website-alt','lni-website','lni-wechat','lni-weight','lni-whatsapp','lni-wheelbarrow','lni-wheelchair','lni-windows','lni-wordpress-filled','lni-wordpress','lni-world-alt','lni-world','lni-write','lni-yahoo','lni-ycombinator','lni-yen','lni-youtube','lni-zip','lni-zoom-in','lni-zoom-out','lni-teabag','lni-stripe','lni-spotify-original'    ];
    echo $form->field($model, 'icon')
    ->radioList($icon, [
        'id' => 'ts-radio',
        'class' => 'btn-group',
        'data-toggle' => 'buttons',
        'unselect' => null,
        'item' => function ($index, $label, $name, $checked, $icon) {
            return '<label class="btn' . ($checked ? ' active' : '') . '">' .
                Html::radio($name, $checked, ['value' => $label, 'class' => 'project-status-btn']) . '<i class="lni '.$label. '"></i><p style="font-size: 7px;">'.$label.'</p>' . '</label>';
        },
    ]);
?> 

    <?= $form->field($model, 'comment')->textarea() ?>

    <?= $form->field($model, 'parent_id')->dropDownList($categories, ['prompt' => '']) ?>

    <?= $form->field($model, 'status')->checkbox(['label' => Yii::t('backend', 'Activate')]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end() ?>

</div>
