<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\parser\models\JsonParser */

// $this->title = $place->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Json Parsers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="json-parser-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
    ]) ?>

</div>
