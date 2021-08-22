<?php

namespace common\models;

use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "{{%federal_district}}".
 *
 * @property int $id
 * @property string $name
 * @property string|null $slug
 * @property int $status
 * @property int|null $country_id
 *
 * @property Country $country
 * @property Region[] $regions
 */
class FederalDistrict extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%federal_district}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'name',
                'slugAttribute' => 'slug',
                'ensureUnique' => true,
                'skipOnEmpty' => true,
                // 'immutable' => true,
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
            ['status', 'default', 'value' => 1],
            [['status', 'country_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::class, 'targetAttribute' => ['country_id' => 'id']],
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
            'country_id' => Yii::t('common', 'Country ID'),
        ];
    }

    /**
     * Gets query for [[Country]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id']);
    }

    /**
     * Gets query for [[Regions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegions()
    {
        return $this->hasMany(Region::class, ['federal_district_id' => 'id']);
    }
}
