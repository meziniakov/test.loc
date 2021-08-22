<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%area}}".
 *
 * @property int $id
 * @property string $name
 * @property string|null $slug
 * @property int $status
 * @property string|null $type
 * @property string|null $type_full
 * @property int|null $region_id
 * @property string|null $fias_id
 * @property int|null $kladr_id
 *
 * @property Region $region
 */
class Area extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%area}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['status', 'region_id', 'kladr_id'], 'integer'],
            ['status', 'default', 'value' => 1],
            [['name', 'slug'], 'string', 'max' => 255],
            [['type', 'type_full'], 'string', 'max' => 20],
            [['fias_id'], 'string', 'max' => 50],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Region::class, 'targetAttribute' => ['region_id' => 'id']],
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
            'type' => Yii::t('common', 'Type'),
            'type_full' => Yii::t('common', 'Type Full'),
            'region_id' => Yii::t('common', 'Region ID'),
            'fias_id' => Yii::t('common', 'Fias ID'),
            'kladr_id' => Yii::t('common', 'Kladr ID'),
        ];
    }

    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Region::class, ['id' => 'region_id']);
    }

    public function getCities()
    {
        return $this->hasMany(City::class, ['area_id' => 'id']);
    }
}
