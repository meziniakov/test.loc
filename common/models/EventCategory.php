<?php

namespace common\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\models\query\EventCategoryQuery;

/**
 * This is the model class for table "{{%event_category}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property integer $parent_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Event[] $events
 * @property EventCategory $parent
 * @property EventCategory[] $eventCategories
 */
class EventCategory extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%event_category}}';
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
            [['parent_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['title', 'slug'], 'string', 'max' => 255],
            ['parent_id', 'exist', 'skipOnError' => true, 'targetClass' => self::class, 'targetAttribute' => ['parent_id' => 'id']],
            ['status', 'default', 'value' => self::STATUS_DRAFT],
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
            'parent_id' => Yii::t('common', 'Parent'),
            'status' => Yii::t('common', 'Status'),
            'created_at' => Yii::t('common', 'Created at'),
            'updated_at' => Yii::t('common', 'Updated at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Event::class, ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(self::class, ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChilds()
    {
        return $this->hasMany(self::class, ['parent_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\EventCategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EventCategoryQuery(get_called_class());
    }
}
