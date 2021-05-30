<?php

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use backend\widgets\TinyMCECallback;
use bs\Flatpickr\FlatpickrWidget;
use dosamigos\selectize\SelectizeTextInput;
use dosamigos\tinymce\TinyMce;
use zakurdaev\editorjs\EditorJsWidget;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $form yii\bootstrap\ActiveForm */

$this->registerJsFile(
    "/static/carousel/bundle.js",
    $options = [
        // 'appendTimestamp' => false,
        'depends' => [
            'yii\web\YiiAsset',
            'yii\bootstrap\BootstrapAsset',
        ]
    ]
);
$this->registerJsFile(
    "https://cdn.jsdelivr.net/npm/@editorjs/checklist@1.3.0/dist/bundle.min.js",
    $options = [
        // 'appendTimestamp' => false,
        'depends' => [
            'yii\web\YiiAsset',
            'yii\bootstrap\BootstrapAsset',
        ]
    ]
);
$this->registerJsFile(
    "https://cdn.jsdelivr.net/npm/@editorjs/marker@1.2.2/dist/bundle.min.js",
    $options = [
        'depends' => [
            'yii\web\YiiAsset',
            'yii\bootstrap\BootstrapAsset',
        ]
    ]
);
?>

<div class="article-form">

    <?php $form = ActiveForm::begin() ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <div class="col-sm-6">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'status')->checkbox(['label' => Yii::t('backend', 'Activate')]) ?>
        <?= $form->field($model, 'city_id')->dropDownList(ArrayHelper::map(
            $cities,
            'id',
            'name'
        ), ['prompt' => '']) ?>
        <?= $form->field($model, 'category_id')->dropDownList(
            ArrayHelper::map(
                $categories,
                'id',
                'title'
            ),
            ['prompt' => '']
        ) ?>
        <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

    </div>

    <div class="col-sm-6">
        <?= $form->field($model, 'imageFile')->fileInput() ?>
        <?php $img = $model->getImage(); ?>
        <?= Html::img($img->getUrl('300x')) ?>
        <button class="btn btn-default" type="button" data-clear="">
            <span class="glyphicon glyphicon-remove"></span>
        </button>

        <?= $form->field($model, 'tagValues')->widget(SelectizeTextInput::class, [
            'loadUrl' => ['tag/list'],
            'options' => ['class' => 'form-control'],
            'clientOptions' => [
                'plugins' => ['remove_button'],
                'valueField' => 'name',
                'labelField' => 'name',
                'searchField' => ['name'],
                'create' => true,
            ],
        ]) ?>
        <?= $form->field($model, 'published_at')->widget(FlatpickrWidget::class, [
            'locale' => strtolower(substr(Yii::$app->language, 0, 2)),
            'plugins' => [
                'confirmDate' => [
                    'confirmIcon' => "<i class='fa fa-check'></i>",
                    'confirmText' => 'OK',
                    'showAlways' => false,
                    'theme' => 'light',
                ],
            ],
            'groupBtnShow' => true,
            'options' => [
                'class' => 'form-control',
            ],
            'clientOptions' => [
                'allowInput' => true,
                'defaultDate' => $model->published_at ? date(DATE_ATOM, $model->published_at) : null,
                'enableTime' => true,
                'time_24hr' => true,
            ],
        ]) ?>
    </div>

    <div class="col-sm-12">
        <?php echo $form->field($model, 'json')->widget(EditorJsWidget::class, [
            'selectorForm' => $form->id,
            'endpoints' => [
                'uploadImageByFile' => Url::to(['/article/upload-file']),
                'uploadImageByUrl' => Url::to(['/article/fetch-url']),
                // 'byFile' => Url::to(['/article/fetch-url']),
            ],
            // 'plugins' => Yii::$app->params['editorjs-widget/plugins'],
            // 'assetClass' => '/assets/'
        ])->label('Редактор');
        ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('backend', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end() ?>
</div>