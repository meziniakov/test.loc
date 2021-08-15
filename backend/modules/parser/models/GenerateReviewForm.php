<?php

namespace backend\modules\parser\models;

use common\models\Place;
use Yii;
use yii\helpers\Json;
use yii\base\Model;

/**
 * Login form.
 */
class GenerateReviewForm extends Model
{
    public $url;
    public $findUrls;
    public $limitUrls;
    public $preSrc;
    public $title;
    public $h1;
    public $description;
    public $preview;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url', 'findUrls', 'title', 'description'], 'required'],
            [['limitUrls'], 'integer'],
            [['url', 'findUrls', 'preSrc', 'h1', 'preview'], 'string'],
            [['title'], 'string', 'max' => 80],
            // [['jsonFile'], 'file', 'extensions' => 'json'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
          'title' => Yii::t('backend', 'SEO заголовок'),
          'h1' => Yii::t('backend', 'Заголовок h1'),
          'description' => Yii::t('backend', 'SEO описание статьи/обзора'),
          'preview' => Yii::t('backend', 'Вступление с описанием статьи/обзора'),
          'url' => Yii::t('backend', 'Введите URL с перечнем объектов для обзора'),
          'findUrls' => Yii::t('backend', 'Введите название класса ссылок'),
          'limitUrls' => Yii::t('backend', 'Количество объектов для обзора'),
          'preSrc' => Yii::t('backend', 'Приставка для ссылок изображений'),
        ];
    }
}