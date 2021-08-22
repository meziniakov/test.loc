<?php

namespace common\models;

use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "{{%region}}".
 *
 * @property int $id
 * @property string $name
 * @property string|null $type
 * @property string|null $type_full
 * @property string|null $slug
 * @property int $status
 * @property int|null $federal_district_id
 * @property string|null $iso_code
 * @property string|null $fias_id
 * @property int|null $kladr_id
 *
 * @property Area[] $areas
 * @property FederalDistrict $federalDistrict
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%region}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'name',
                'slugAttribute' => 'slug',
                'ensureUnique' => true,
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
            [['status', 'federal_district_id', 'kladr_id'], 'integer'],
            ['status', 'default', 'value' => 1],
            [['name'], 'string', 'max' => 255],
            [['type', 'type_full'], 'string', 'max' => 20],
            [['iso_code'], 'string', 'max' => 10],
            [['fias_id'], 'string', 'max' => 50],
            [['federal_district_id'], 'exist', 'skipOnError' => true, 'targetClass' => FederalDistrict::class, 'targetAttribute' => ['federal_district_id' => 'id']],
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
            'type' => Yii::t('common', 'Type'),
            'type_full' => Yii::t('common', 'Type Full'),
            'slug' => Yii::t('common', 'Slug'),
            'status' => Yii::t('common', 'Status'),
            'federal_district_id' => Yii::t('common', 'Federal District ID'),
            'iso_code' => Yii::t('common', 'Iso Code'),
            'fias_id' => Yii::t('common', 'Fias ID'),
            'kladr_id' => Yii::t('common', 'Kladr ID'),
        ];
    }

    /**
     * Gets query for [[Areas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAreas()
    {
        return $this->hasMany(Area::class, ['region_id' => 'id']);
    }

    /**
     * Gets query for [[FederalDistrict]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFederalDistrict()
    {
        return $this->hasOne(FederalDistrict::class, ['id' => 'federal_district_id']);
    }
}
