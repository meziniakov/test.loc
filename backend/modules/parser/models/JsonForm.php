<?php

namespace backend\modules\parser\models;

use common\models\Place;
use Yii;
use yii\helpers\Json;
use yii\base\Model;

/**
 * Login form.
 */
class JsonForm extends Model
{
    public $jsonFile;
    public $jsonFileByURL;
    public $parts;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['jsonFile'], 'safe'],
            [['parts'], 'integer'],
            [['jsonFileByURL'], 'string'],
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

    public function uploadJsonFile()
    {
        if ($this->validate()) {
            // var_dump($this->getErrors());die;
            $path = Yii::getAlias('@storage') . '/json/' . $this->jsonFile->baseName . '.' . $this->jsonFile->extension;
            $this->jsonFile->saveAs($path, false);
            return $path;
        } else {
            var_dump($this->getErrors());die;
            return false;
        }
    }
}