<?php

namespace common\models;

use Yii;
use creocoder\taggable\TaggableBehavior;
use yii\bootstrap\Html;
use common\models\Tag;
use common\models\query\OrganizationQuery;

/**
 * This is the model class for table "organization".
 *
 * @property int $org_id
 * @property string $org_type
 * @property string $org_name
 * @property string $org_description
 * @property int|null $org_phone
 * @property int $org_category
 * @property float $lon
 * @property float $lat
 *
 */
class Organization extends \yii\db\ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;

    public $imageFile;
    public $imageFiles;

    public function behaviors()
    {
        return [
            'taggable' => [
                'class' => TaggableBehavior::class,
                'tagValuesAsArray' => false,
                'tagRelation' => 'tags',
                'tagValueAttribute' => 'name',
                'tagFrequencyAttribute' => 'frequency',
            ],
            // 'images' => [
            //     'class' => 'dvizh\gallery\behaviors\AttachImages',
            //     'mode' => 'gallery',
            //     'quality' => 60,
            //     'galleryId' => 'picture'
            // ],
            'image' => [
                'class' => 'alex290\yii2images\behaviors\ImageBehave',
            ]
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%organization}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            [['description'], 'string'],
            [['lat', 'lng'], 'number'],
            ['published_at', 'default',
            'value' => function () {
                return date(DATE_ATOM);
                }
            ],
            ['published_at', 'filter', 'filter' => 'strtotime'],
            [['status', 'category_id', 'author_id', 'updater_id', 'created_at', 'updated_at', 'phone'], 'integer'],
            [['type', 'name', 'slug', 'keywords'], 'string', 'max' => 255],
            ['status', 'default', 'value' => self::STATUS_DRAFT],
            ['author_id', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['author_id' => 'id']],
            ['category_id', 'exist', 'skipOnError' => true, 'targetClass' => CompanyCategory::class, 'targetAttribute' => ['category_id' => 'id']],
            ['updater_id', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updater_id' => 'id']],
            ['tagValues', 'safe'],
            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg'],
            [['imageFiles'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Org ID',
            'type' => 'Org Type',
            'name' => 'Org Name',
            'description' => 'Org Description',
            'phone' => 'Org Phone',
            'category' => 'Org Category',
            'tagValues' => 'Tags',
            'imageFile' => Yii::t('backend', 'Image Upload'),
            'imageFiles' => Yii::t('backend', 'Images Upload'),
        ];
    }

    /**
     * Gets query for [[Adresses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdresses()
    {
        return $this->hasMany(Adresses::class, ['id' => 'org_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(CompanyCategory::class, ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(CompanyCategory::class, ['id' => 'parent_id']);
    }

    public function getParentName()
    {
        $parent = $this->parent;

        return $parent ? $parent->name : '';
    }

    /**
     * Gets query for [[SocLinks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSocLinks()
    {
        return $this->hasMany(SocLinks::class, ['id' => 'org_id']);
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new OrganizationQuery(get_called_class());
    }

    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])
            ->viaTable('{{%org_id_tag_id}}', ['org_id' => 'id']);
    }

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

    public function uploadMainImage()
    {
        if($this->validate()){
            $path = Yii::getAlias('@storage') . '/img/'. $this->imageFile->baseName . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs($path, false);
            $this->attachImage($path, true);
            @unlink($path);
            return true;
        } else {
            return false;
        }
    }

    public function uploadGallery()
    {
        if($this->validate()){
            foreach ($this->imageFiles as $file) {
            $path = Yii::getAlias('@storage') . '/img/' . $file->baseName . '.' . $file->extension;
            $file->saveAs($path, false);
            $this->attachImage($path, false);
            @unlink($path);
            }
            return true;
        } else {
            return false;
        }
    }


    // public function upload()
    // {
    //     if($this->validate()){
    //         $path = Yii::getAlias('@storage') . '/img/'. $this->imageFile->baseName . '.' . $this->imageFile->extension;
    //         $this->imageFile->saveAs($path);
    //         $this->attachImage($path);
    //         return true;
    //     } else {
    //         return false;
    //     }
        
    // }
}
