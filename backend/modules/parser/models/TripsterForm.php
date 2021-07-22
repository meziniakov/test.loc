<?php

namespace backend\modules\parser\models;

use common\models\Place;
use Yii;
use yii\helpers\Json;
use yii\base\Model;

/**
 * Login form.
 */
class TripsterForm extends Model
{
    public $jsonFile;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['jsonFile'], 'required'],
            // [['jsonFile'], 'file', 'extensions' => 'json'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
          'jsonFile' => Yii::t('backend', 'Json file'),
        ];
    }
}