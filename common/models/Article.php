<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use common\models\query\ArticleQuery;
use common\models\City;
use creocoder\taggable\TaggableBehavior;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $keywords
 * @property string $preview
 * @property string $body
 * @property integer $status
 * @property integer $category_id
 * @property integer $author_id
 * @property integer $updater_id
 * @property integer $published_at
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property string $tagValues
 *
 * @property User $author
 * @property ArticleCategory $category
 * @property User $updater
 * @property Tag[] $tags
 */
class Article extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;

    const STATUS_ALL = 10;
    const STATUS_PARSED = 1;
    const STATUS_EDITED = 2;
    const STATUS_PUBLISHED = 3;
    const STATUS_UPDATED = 4;
    const STATUS_TRASHED = 0;

    const PAGE_SIZE = 10;

    public $imageFile;
    public $_city_id;
    public $_category_id;
    public $_limit;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'author_id',
                'updatedByAttribute' => 'updater_id',
            ],
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                'ensureUnique' => true,
                'immutable' => true,
            ],
            TaggableBehavior::class,
            'image' => [
                'class' => 'alex290\yii2images\behaviors\ImageBehave',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'category_id'], 'required'],
            [['preview', 'body'], 'string'],
            ['published_at', 'default',
                'value' => function () {
                    return date(DATE_ATOM);
                }
            ],
            ['published_at', 'filter', 'filter' => 'strtotime'],
            [['status', 'category_id', 'city_id', 'author_id', 'updater_id', 'created_at', 'updated_at'], 'integer'],
            [['title', 'slug', 'description', 'keywords'], 'string', 'max' => 255],
            ['status', 'default', 'value' => self::STATUS_DRAFT],
            ['author_id', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['author_id' => 'id']],
            ['city_id', 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['city_id' => 'id']],
            ['category_id', 'exist', 'skipOnError' => true, 'targetClass' => ArticleCategory::class, 'targetAttribute' => ['category_id' => 'id']],
            ['updater_id', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updater_id' => 'id']],
            [['tagValues', 'json', '_city_id', '_category_id', '_limit'], 'safe'],
            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg'],
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
            'description' => Yii::t('common', 'Description'),
            'keywords' => Yii::t('common', 'Keywords'),
            'preview' => Yii::t('common', 'Preview'),
            'body' => Yii::t('common', 'Text'),
            '_category_id' => 'Категории мест',
            'json' => 'Json',
            'status' => Yii::t('common', 'Status'),
            'city_id' => Yii::t('backend', 'City'),
            'category_id' => Yii::t('common', 'Category'),
            'author_id' => Yii::t('common', 'Author'),
            'updater_id' => Yii::t('common', 'Updater'),
            'published_at' => Yii::t('common', 'Published at'),
            'created_at' => Yii::t('common', 'Created at'),
            'updated_at' => Yii::t('common', 'Updated at'),
            'tagValues' => Yii::t('common', 'Tags'),
            'imageFile' => Yii::t('common', 'Обложка'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

    public static function getDataProvider($query)
    {
        $countQuery = clone $query;

        return new ActiveDataProvider([
            'query' => $query,
            'totalCount' => (int)$countQuery->count(),
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
                'pageSizeParam' => false,
                'forcePageParam' => false
            ],
            'sort' => [
                'defaultOrder' => [
                    'title' => SORT_ASC,
                    'created_at' => SORT_DESC
                ]
            ],
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ArticleCategory::class, ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(User::class, ['id' => 'updater_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->viaTable('{{%article_tag}}', ['article_id' => 'id']);
    }

    /**
     * Returns tags that post is tagged with (as links).
     *
     * @return string 
     */
    public function getTagLinks()
    {
        $tagLinks = [];

        foreach ($this->tags as $tag) {
            $tagLinks[] = Html::a($tag->name, ['tag', 'slug' => $tag->slug]);
        }

        return implode(', ', $tagLinks);
    }

    public function getTagLinksArray()
    {
        $tagLinks = [];

        foreach ($this->tags as $tag) {
            $tagLinks[] = Html::a($tag->name, ['tag', 'slug' => $tag->slug]);
        }

        return $tagLinks;
    }

    /**
     * @inheritdoc
     * @return \common\models\query\ArticleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ArticleQuery(get_called_class());
    }

    public function uploadMainImage()
    {
        if ($this->validate()) {
            $path = Yii::getAlias('@storage') . '/img/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs($path, false);
            $this->attachImage($path, true);
            @unlink($path);
            return true;
        } else {
            return false;
        }
    }

}
