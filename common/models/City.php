<?php

namespace common\models;

use common\models\query\CityQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;
use yii\helpers\Url;
// use alex290\yii2images\models\Image;
/**
 * This is the model class for table "city".
 *
 * @property int $id
 * @property string $name
 * @property string $url
 */
class City extends \yii\db\ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_ACTIVE = 1;

    public $imageFile;
    public $imageFiles = [];
    public $image;
    public $images;
    public $placeCount;

    public function behaviors()
    {
        return [
            // TimestampBehavior::class,
            // [
            //     'class' => BlameableBehavior::class,
            //     'updatedByAttribute' => 'updater_id',
            //     'createdByAttribute' => 'author_id',

            // ],
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'name',
                'slugAttribute' => 'url',
                'ensureUnique' => true,
                'immutable' => true,
            ],
            'image' => [
                'class' => 'alex290\yii2images\behaviors\ImageBehave',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%city}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'url'], 'required'],
            [['name', 'url'], 'unique'],
            [['lat', 'lng'], 'number'],
            // [['status', 'created_at', 'updated_at'], 'integer'],
            ['status', 'default', 'value' => self::STATUS_DRAFT],
            [['name', 'url', 'youtube_url', 'website', 'in_obj_phrase', 'iata', 'name_en'], 'string', 'max' => 255],
            [['preview', 'description'], 'string'],
            [['title', 'h1'], 'string', 'max' => 80],
            [['ascii_name','in_obj_phrase','from_obj_phrase', 'name_prepositional'], 'string', 'max' => 20],
            // ['author_id', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['author_id' => 'id']],
            // ['category_id', 'exist', 'skipOnError' => true, 'targetClass' => PlaceCategory::class, 'targetAttribute' => ['category_id' => 'id']],
            // ['updater_id', 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['updater_id' => 'id']],
            [['image', 'images', 'gallery', 'places', 'placeCount'], 'safe'],
            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg, webp'],
            [['imageFiles'], 'file', 'extensions' => 'png, jpg, jpeg, webp', 'maxFiles' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'description' => Yii::t('backend', 'Description'),
            'preview' => Yii::t('backend', 'Preview'),
            'url' => Yii::t('backend', 'URL'),
            'lat' => Yii::t('backend', 'Широта'),
            'lng' => Yii::t('backend', 'Долгота'),
            'youtube_url' => Yii::t('backend', 'YouTube'),
            // 'category_id' => Yii::t('backend', 'Place category'),
            'status' => Yii::t('backend', 'Status'),
            // 'is_home' => Yii::t('backend', 'On home page'),
            'imageFile' => Yii::t('backend', 'Image Upload'),
            'imageFiles' => Yii::t('backend', 'Images Upload'),
        ];
    }

    public function getPlacies()
    {
        return $this->hasMany(Place::class, ['city_id' => 'id']);
    }

    // public function placeCount()
    // {
    //     return Place::find()->where(['city_id' => $this->id])->count();
    // }

    // public function eventCount()
    // {
    //     return Event::find()->where(['city_id' => $this->id])->count();
    // }

    public function getPlaceCount()
    {
        return $this->hasMany(Place::class, ['city_id' => $this->id])->count();
    }

    public function getImageRico(){
        return $this->hasOne(\alex290\yii2images\models\Image::class, ['itemId' => 'id'])->where(['modelName' => $this->formName()])->andWhere(['isMain' => 1]);
    }

    public function getImagesRico(){
        return $this->hasMany(\alex290\yii2images\models\Image::class, ['itemId' => 'id'])->where(['modelName' => $this->formName()]);
    }

    public static function find()
    {
        return new CityQuery(get_called_class());
    }

    public function download($url, $pathinfo)
    {
        $path = Yii::getAlias('@storage') . '/tmp/' . $pathinfo['filename'] . '.' . $pathinfo['extension'];
        $file_path = fopen($path, 'w');
        $client = new \GuzzleHttp\Client(['connect_timeout' => 30, 'timeout' => 30]);
        $this->imageFile = $client->get($url, ['sink' => $file_path]);
        return true;
    }

    public function uploadImage($pathinfo, $name_ru)
    {
        if ($this->validate()) {
            $path = Yii::getAlias('@storage') . '/tmp/' . $pathinfo['filename'] . '.' . $pathinfo['extension'];
            $this->attachImage($path, true, $pathinfo['filename']);
            $image = \alex290\yii2images\models\Image::findOne(['name' => $pathinfo['filename']]);
            $image->alt = $name_ru;
            $image->title = $name_ru;
            $image->save(false);
            @unlink($path);
            return true;
        } else {
            return false;
        }
    }

    public function uploadMainImage()
    {
        if ($this->validate()) {
            // $this->getErrors();
            $path = Yii::getAlias('@storage') . '/tmp/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs($path, false);
            $this->attachImage($path, true);
            @unlink($path);
            return true;
        } else {
            // $this->getErrors();
            return false;
        }
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


}
