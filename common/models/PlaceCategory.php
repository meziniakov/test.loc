<?php

namespace common\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\models\query\PlaceCategoryQuery;

/**
 * This is the model class for table "{{%place_category}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property string $comment
 * @property integer $parent_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Place[] $places
 * @property PlaceCategory $parent
 * @property PlaceCategory[] $placeCategories
 */
class PlaceCategory extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;

    // public $cnt;
    public $klass;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%place_category}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                'ensureUnique' => true,
                'immutable' => true,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['title', 'required'],
            ['comment', 'string'],
            [['parent_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['title', 'slug', 'icon'], 'string', 'max' => 255],
            ['parent_id', 'exist', 'skipOnError' => true, 'targetClass' => self::class, 'targetAttribute' => ['parent_id' => 'id']],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('common', 'Title'),
            'slug' => Yii::t('common', 'Slug'),
            'icon' => Yii::t('common', 'Icon'),
            'comment' => Yii::t('common', 'Comment'),
            'parent_id' => Yii::t('common', 'Parent'),
            'status' => Yii::t('common', 'Status'),
            'created_at' => Yii::t('common', 'Created at'),
            'updated_at' => Yii::t('common', 'Updated at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaces()
    {
        return $this->hasMany(Place::class, ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(self::class, ['parent_id' =>'id']);
    }

    // public function getParentName()
    // {
    //     $parent = $this->parent;

    //     return $parent ? $parent->name : '';
    // }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChilds()
    {
        return $this->hasMany(self::class, ['parent_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\PlaceCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PlaceCategoryQuery(get_called_class());
    }
}
