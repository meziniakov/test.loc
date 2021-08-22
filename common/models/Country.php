<?php

namespace common\models;

use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "{{%country}}".
 *
 * @property int $id
 * @property string $name
 * @property string|null $slug
 * @property int $status
 * @property string|null $iso_code
 *
 * @property FederalDistrict[] $federalDistricts
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%country}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'name',
                'slugAttribute' => 'slug',
                'ensureUnique' => true,
                'immutable' => true,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['iso_code'], 'string', 'max' => 10],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'name' => Yii::t('common', 'Name'),
            'slug' => Yii::t('common', 'Slug'),
            'status' => Yii::t('common', 'Status'),
            'iso_code' => Yii::t('common', 'Iso Code'),
        ];
    }

    /**
     * Gets query for [[FederalDistricts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFederalDistricts()
    {
        return $this->hasMany(FederalDistrict::class, ['country_id' => 'id']);
    }
}
