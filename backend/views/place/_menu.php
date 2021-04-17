<?php

use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;
use yii\helpers\Html;

$action = Yii::$app->controller->action->id;
$controller = Yii::$app->controller->id;

$backTo = null;
$indexUrl = Url::to(['/' . $controller]);
$parsedUrl = Url::to(['/' . $controller . '/parsed']);
$editedUrl = Url::to(['/' . $controller . '/edited']);
$publishedUrl = Url::to(['/' . $controller . '/published']);
$updatedUrl = Url::to(['/' . $controller . '/updated']);
$trashedUrl = Url::to(['/' . $controller . '/trashed']);
?>
<ul class="nav nav-pills">
  <li <?= ($action === 'index') ? 'class="active"' : '' ?>>
    <a href="<?= $indexUrl ?>">
      <?php if ($backTo === 'index') : ?>
        <i class="glyphicon glyphicon-chevron-left fs-12"></i>
      <?php endif; ?>
      <?= Yii::t('backend', 'All') ?>
      <?php if ($this->context->all > 0) : ?>
        <span class="badge"><?= $this->context->all ?></span>
      <?php endif; ?>
    </a>
  </li>
  <li <?= ($action === 'parsed') ? 'class="active"' : '' ?>>
    <a href="<?= $parsedUrl ?>">
      <?php if ($backTo === 'parsed') : ?>
        <i class="glyphicon glyphicon-chevron-left fs-12"></i>
      <?php endif; ?>
      <?= Yii::t('backend', 'Parsed') ?>
      <?php if ($this->context->parsed > 0) : ?>
        <span class="badge"><?= $this->context->parsed ?></span>
      <?php endif; ?>
    </a>
  </li>
  <li <?= ($action === 'edited') ? 'class="active"' : '' ?>>
    <a href="<?= $editedUrl ?>">
      <?php if ($backTo === 'edited') : ?>
        <i class="glyphicon glyphicon-chevron-left fs-12"></i>
      <?php endif; ?>
      <?= Yii::t('backend', 'Edited') ?>
      <?php if ($this->context->edited > 0) : ?>
        <span class="badge"><?= $this->context->edited ?></span>
      <?php endif; ?>
    </a>
  </li>
  <li <?= ($action === 'published') ? 'class="active"' : '' ?>>
    <a href="<?= $publishedUrl ?>">
      <?php if ($backTo === 'published') : ?>
        <i class="glyphicon glyphicon-chevron-left fs-12"></i>
      <?php endif; ?>
      <?= Yii::t('backend', 'Published') ?>
      <?php if ($this->context->published > 0) : ?>
        <span class="badge"><?= $this->context->published ?></span>
      <?php endif; ?>
    </a>
  </li>
  <li <?= ($action === 'updated') ? 'class="active"' : '' ?>>
    <a href="<?= $updatedUrl ?>">
      <?php if ($backTo === 'updated') : ?>
        <i class="glyphicon glyphicon-chevron-left fs-12"></i>
      <?php endif; ?>
      <?= Yii::t('backend', 'Updated') ?>
      <?php if ($this->context->updated > 0) : ?>
        <span class="badge"><?= $this->context->updated ?></span>
      <?php endif; ?>
    </a>
  </li>
  <li <?= ($action === 'trashed') ? 'class="active"' : '' ?>>
    <a href="<?= $trashedUrl ?>">
      <?php if ($backTo === 'trashed') : ?>
        <i class="glyphicon glyphicon-chevron-left fs-12"></i>
      <?php endif; ?>
      <?= Yii::t('backend', 'Trashed') ?>
      <?php if ($this->context->trashed > 0) : ?>
        <span class="badge"><?= $this->context->trashed ?></span>
      <?php endif; ?>
    </a>
  </li>
</ul>
<br>
<div class="btn-group">
  <?= Html::a(Yii::t('backend', 'Add'), ['create'], ['class' => 'btn btn-success']) ?>
  <?= ButtonDropdown::widget([
    'label' => 'Сменить статус',
    'dropdown' => [
      'items' => [
        ['label' => 'Спарсено', 'url' => [''], 'linkOptions' => ['id' => 'ToParsed']],
        ['label' => 'Отредактировано', 'url' => [''], 'linkOptions' => ['id' => 'ToEdited']],
        ['label' => 'Опубликовано', 'url' => [''], 'linkOptions' => ['id' => 'ToPublished']],
        ['label' => 'Обновлено', 'url' => [''], 'linkOptions' => ['id' => 'ToUpdated']],
        ['label' => 'В корзину', 'url' => '', 'linkOptions' => ['id' => 'ToTrashed']],
        ['label' => 'Удалить', 'url' => '', 'linkOptions' => ['id' => 'ToDeleted']],
      ],
    ],
    'containerOptions' => ['class' => '']
  ]);
  ?>
  <?php
  $array = [];
  foreach ($categories as $category) {
    $array[] = ['label' => $category->title, 'url' => [''], 'id' => $category->id, 'linkOptions' => ['id' => $category->slug]];
  }
  $_cities = [];
  foreach ($cities as $city) {
    $_cities[] = ['label' => $city->name, 'url' => [''], 'id' => $city->id, 'linkOptions' => ['id' => $city->url]];
  }
  // var_dump($_cities);die;
  ?>
  <?php echo ButtonDropdown::widget([
    'label' => 'Сменить категорию',
    'dropdown' => [
      'items' => $array,
    ],
    'containerOptions' => ['class' => '']
  ]);
  echo ButtonDropdown::widget([
    'label' => 'Установить город',
    'dropdown' => [
      'items' => $_cities,
    ],
    'containerOptions' => ['class' => '']
  ]);
  ?>
</div>
<?php
  foreach ($array as $item) {
  $this->registerJs('$(document).ready(function(){$(\'#' . $item['linkOptions']['id'] . '\').click(function(){
        var id = $(\'#grid\').yiiGridView(\'getSelectedRows\');
          $.ajax({
            type: \'POST\',
            url : \'/place/multiple-change-category\',
            data : {id: id, category_id: '. $item['id'] .'},
            success : function() {
              $(this).closest(\'tr\').remove(); //удаление строки
            },
          });
        });
      });
      ', \yii\web\View::POS_READY);
    }

  foreach ($_cities as $item) {
  $this->registerJs('$(document).ready(function(){$(\'#' . $item['linkOptions']['id'] . '\').click(function(){
        var id = $(\'#grid\').yiiGridView(\'getSelectedRows\');
          $.ajax({
            type: \'POST\',
            url : \'/place/multiple-change-city\',
            data : {id: id, city_id: '. $item['id'] .'},
            success : function() {
              $(this).closest(\'tr\').remove(); //удаление строки
            },
          });
        });
      });
      ', \yii\web\View::POS_READY);
    }
      ?>