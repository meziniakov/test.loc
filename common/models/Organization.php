<?php

namespace common\models;

use Yii;
use creocoder\taggable\TaggableBehavior;
use yii\bootstrap\Html;
use common\models\Tag;
use common\models\query\OrganizationQuery;
use yii\helpers\Url;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "organization".
 *
 * @property int $org_id
 * @property string $org_type
 * @property string $org_name
 * @property string $description
 * @property string $city
 * @property string $address
 * @property int|null $org_phone
 * @property int $org_category
 * @property float $lon
 * @property float $lat
 *
 */
class Organization extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;
    const PAGE_SIZE = 6;

    public $cnt;
    public $imageFile;
    public $imageFiles;
    public $images;

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => BlameableBehavior::class,
                'updatedByAttribute' => 'updater_id',
                'createdByAttribute' => 'author_id',

            ],
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
            // [['name', 'description'], 'required'],
            [['description', 'city', 'address'], 'string'],
            [['lat', 'lng'], 'number'],
            // ['published_at', 'default', 'value' => date('Y-m-d H:i:s')],
            ['date_parsed', 'safe'],
            ['tmp_uniq', 'safe'],
            // ['published_at', 'filter', 'filter' => 'strtotime'],
            [['status', 'category_id', 'author_id', 'updater_id', 'created_at', 'updated_at', 'phone'], 'integer'],
            [['url', 'type', 'name', 'slug', 'keywords'], 'string', 'max' => 255],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['author_id', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['author_id' => 'id']],
            ['category_id', 'exist', 'skipOnError' => true, 'targetClass' => CompanyCategory::class, 'targetAttribute' => ['category_id' => 'id']],
            ['updater_id', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updater_id' => 'id']],
            ['tagValues', 'safe'],
            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg'],
            [['imageFiles'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 15],
            [['images'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 15],
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
            'city' => 'City',
            'address' => 'Address',
            'phone' => 'Org Phone',
            'category' => 'Org Category',
            'category_id' => 'Org Category',
            'tagValues' => 'Tags',
            'imageFile' => Yii::t('backend', 'Image Upload'),
            'imageFiles' => Yii::t('backend', 'Images Upload'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(CompanyCategory::class, ['id' => 'category_id']);
    }

    public static function getAllPages(): ActiveDataProvider
    {
        $query = self::find()->active();
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
                    'name' => SORT_ASC,
                    'created_at' => SORT_DESC
                ]
            ],
        ]);
    }

    public static function getSearchPages(): ActiveDataProvider
    {
        $q = Yii::$app->request->get('q');
        $category_id = Yii::$app->request->get('category_id');
        $tag_id = Yii::$app->request->get('tag_id');
        $query = self::find();
        $query->andFilterWhere([
            'category_id' => $category_id,
            'tag_id' => $tag_id,
        ]);
        $query->andFilterWhere(['like', 'name', $q]);
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
                    'name' => SORT_ASC,
                    'created_at' => SORT_DESC
                ]
            ],
        ]);
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
    public function uploadImage($pathinfo)
    {
        if ($this->validate()) {
            $path = Yii::getAlias('@storage') . '/img/' . $pathinfo['filename'] . '.' . $pathinfo['extension'];
            // $this->imageFile->saveAs($path, false);
            $this->attachImage($path, true);
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

    public function uploadImages($imageFiles)
    {
        if ($this->validate()) {
            // var_dump($imageFiles);die;
            foreach ($imageFiles as $file) {
                $path = Yii::getAlias('@storage') . '/img/' . $file['filename'] . '.' . $file['extension'];
                // var_dump($file);die;
                // $file->saveAs($path, false);
                $this->attachImage($path, false);
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
