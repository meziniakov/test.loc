<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use creocoder\taggable\TaggableBehavior;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use common\models\Tag;
use common\models\query\PlaceQuery;



/**
 * This is the model class for table "Place".
 *
 * @property int $id
 * @property string $type
 * @property string $name
 * @property string $description
 * @property string $city
 * @property string $address
 * @property int|null $phone
 * @property int $place_category
 * @property float $lon
 * @property float $lat
 *
 */
class Place extends ActiveRecord
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

    public $cnt;
    public $imageFile;
    public $imageFiles;
    public $image;
    public $images;
    public $gallery;

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => BlameableBehavior::class,
                'updatedByAttribute' => 'updater_id',
                'createdByAttribute' => 'author_id',

            ],
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                'ensureUnique' => true,
                'immutable' => true,
            ],
            'taggable' => [
                'class' => TaggableBehavior::class,
                'tagValuesAsArray' => false,
                'tagRelation' => 'tags',
                'tagValueAttribute' => 'name',
                'tagFrequencyAttribute' => 'frequency',
            ],
            'image' => [
                'class' => 'alex290\yii2images\behaviors\ImageBehave',
            ],
            'saveRelations' => [
                'class'     => SaveRelationsBehavior::class,
                'relations' => [
                    'company',
                    'users',
                    // 'image' => ['cascadeDelete' => true],
                    'tags'  => [
                        'extraColumns' => function ($model) {
                            /** @var $model Tag */
                            return [
                                'order' => $model->order
                            ];
                        }
                    ]
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%place}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'text'], 'required'],
            [['text', 'address'], 'string'],
            [['lat', 'lng'], 'number'],
            ['published_at', 'default',
                'value' => function () {
                    return date(DATE_ATOM);
                }
            ],
            ['published_at', 'filter', 'filter' => 'strtotime'],
            ['date_parsed', 'safe'],
            ['tmp_uniq', 'safe'],
            [['status', 'is_home', 'category_id', 'city_id', 'author_id', 'updater_id', 'created_at', 'updated_at'], 'integer'],
            [['url', 'description', 'title', 'website', 'street', 'street_comment'], 'string', 'max' => 255],
            ['status', 'default', 'value' => self::STATUS_PARSED],
            ['author_id', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['author_id' => 'id']],
            ['category_id', 'exist', 'skipOnError' => true, 'targetClass' => PlaceCategory::class, 'targetAttribute' => ['category_id' => 'id']],
            ['city_id', 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['city_id' => 'id']],
            ['updater_id', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updater_id' => 'id']],
            [['tagValues', 'slug'], 'safe'],
            [['image', 'images', 'gallery'], 'safe'],
            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg'],
            [['imageFiles'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 25],
            // [['images'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'title' => Yii::t('backend', 'Title'),
            'slug' => Yii::t('backend', 'URL'),
            'description' => Yii::t('backend', 'Description'),
            'text' => Yii::t('backend', 'Text'),
            'city_id' => Yii::t('backend', 'City'),
            'address' => Yii::t('backend', 'Address'),
            'phone' => Yii::t('backend', 'Phones'),
            'category_id' => Yii::t('backend', 'Place category'),
            'tagValues' => Yii::t('backend', 'Tags'),
            'status' => Yii::t('backend', 'Status'),
            'is_home' => Yii::t('backend', 'On home page'),
            'imageFile' => Yii::t('backend', 'Image Upload'),
            'imageFiles' => Yii::t('backend', 'Images Upload'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(PlaceCategory::class, ['id' => 'category_id']);
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

    public static function getJsonForMap($models)
    {
        if (is_array($models)) {
            foreach ($models as $row) {
                $img = $row->getImage();
                $addressInJson[] = [
                    'addres' => trim($row['address']),
                    'title' => $row['title'],
                    'slug' => $row['slug'],
                    'mainImg' => $img->getUrl('358x229'),
                    'category' => $row['category']['title'],
                    'categorySlug' => $row['category']['slug'],
                    'lng' => $row['lng'],
                    'lat' => $row['lat'],
                ];
            }
        } else {
            $addressInJson[] = [
                'addres' => trim($models['address']),
                'title' => $models['title'],
                'slug' => $models['slug'],
                'category' => $models['category']['title'],
                'categorySlug' => $models['category']['slug'],
                'lng' => $models['lng'],
                'lat' => $models['lat'],
            ];
        }
        if (isset($addressInJson) && $addressInJson) {
            return $addressInJson = Json::encode($addressInJson);
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(PlaceCategory::class, ['id' => 'parent_id']);
    }

    public function getParentName()
    {
        $parent = $this->parent;

        return $parent ? $parent->name : '';
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new PlaceQuery(get_called_class());
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
    public function uploadImage($pathinfo, $object)
    {
        if ($this->validate()) {
            $path = Yii::getAlias('@storage') . '/img/' . $pathinfo['filename'] . '.' . $pathinfo['extension'];
            $this->attachImage($path, true, $pathinfo['filename']);
            $image = \alex290\yii2images\models\Image::findOne(['name' => $pathinfo['filename']]);
            $image->alt = $object->name;
            $image->title = $object->name;
            $image->save(false);
            @unlink($path);
            return true;
        } else {
            return false;
        }
    }

    public function uploadGallery()
    {
        if ($this->validate()) {
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

    public function uploadImages($imageFiles, $object)
    {
        if ($this->validate()) {
            foreach ($imageFiles as $file) {
                $path = Yii::getAlias('@storage') . '/img/' . $file['filename'] . '.' . $file['extension'];
                $this->attachImage($path, false, $file['filename']);
                $image = \alex290\yii2images\models\Image::findOne(['name' => $file['filename']]);
                $image->alt = $object->name;
                $image->title = $object->name;
                $image->save(false);    
                @unlink($path);
            }
            return true;
        } else {
            return false;
        }
    }

    public function download($url, $pathinfo)
    {
        $path = Yii::getAlias('@storage') . '/img/' . $pathinfo['filename'] . '.' . $pathinfo['extension'];
        $file_path = fopen($path, 'w');
        $client = new \GuzzleHttp\Client(['connect_timeout' => 30, 'timeout' => 30]);
        $this->imageFile = $client->get($url, ['sink' => $file_path]);
        // $this->attachImage($path, false);
        // @unlink($path);
        return true;
    }

    public function getUrl($size = false)
    {
        $urlSize = ($size) ? '_' . $size : '';
        $url = Url::toRoute([
            // '/'.$this->getPrimaryKey().
            '/yii22images/images/image-by-item-and-alias',
            'item' => $this->modelName . $this->itemId,
            'dirtyAlias' =>  $this->urlAlias . $urlSize . '.' . $this->getExtension()
        ]);
        return $url;
    }


    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            Yii::$app->session->setFlash('success', 'Запись добавлена');
        } else {
            Yii::$app->session->setFlash('success', 'Запись обновлена');
        }
        parent::afterSave($insert, $changedAttributes);
    }
}
