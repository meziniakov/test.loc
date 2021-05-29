<?php

namespace backend\modules\parser\models;

use common\models\Place;
use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "json_parser".
 *
 * @property int $id
 * @property string|null $src_id
 * @property string $title
 * @property string|null $description
 * @property string|null $city_name
 * @property string|null $city_sys_name
 * @property string|null $city_src_id
 * @property string|null $street
 * @property string|null $street_comment
 * @property string|null $full_address
 * @property string|null $lat
 * @property string|null $lng
 * @property string|null $category_name
 * @property string|null $category_sys_name
 * @property string|null $image_url
 * @property string|null $image_alt
 * @property string|null $gallery_url
 * @property string|null $gallery_alt
 * @property string|null $tag_name
 * @property string|null $tag_sys_name
 * @property string|null $working_schedule
 * @property string|null $website
 * @property string|null $email
 * @property string|null $phones
 * @property string|null $phones_comment
 */
class JsonParser extends \yii\db\ActiveRecord
{
    public $jsonFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'json_parser';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'src_id', 'description', 'city_name', 'city_sys_name', 'city_src_id', 'street', 'street_comment', 'full_address', 'category_name', 'category_sys_name', 'image_url', 'image_alt', 'gallery_url', 'gallery_alt', 'tag_name', 'tag_sys_name', 'working_schedule', 'website', 'email', 'phones', 'phones_comment'], 'string', 'max' => 20],
            [['lat', 'lng'], 'string', 'max' => 50],
            // [['jsonFile'], 'file', 'extensions' => 'json'],
            [['gallery', 'jsonFile'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('backend', 'ID'),
            'src_id' => Yii::t('backend', 'Src ID'),
            'name' => Yii::t('backend', 'Name'),
            'description' => Yii::t('backend', 'Description'),
            'city_name' => Yii::t('backend', 'City Name'),
            'city_sys_name' => Yii::t('backend', 'City Sys Name'),
            'city_src_id' => Yii::t('backend', 'City Src ID'),
            'street' => Yii::t('backend', 'Street'),
            'street_comment' => Yii::t('backend', 'Street Comment'),
            'full_address' => Yii::t('backend', 'Full Address'),
            'lat' => Yii::t('backend', 'Lat'),
            'lng' => Yii::t('backend', 'Lng'),
            'category_name' => Yii::t('backend', 'Category Name'),
            'category_sys_name' => Yii::t('backend', 'Category Sys Name'),
            'image_url' => Yii::t('backend', 'Image Url'),
            'image_alt' => Yii::t('backend', 'Image Alt'),
            'gallery_url' => Yii::t('backend', 'Gallery Url'),
            'gallery_alt' => Yii::t('backend', 'Gallery Alt'),
            'tag_name' => Yii::t('backend', 'Tag Name'),
            'tag_sys_name' => Yii::t('backend', 'Tag Sys Name'),
            'working_schedule' => Yii::t('backend', 'Working Schedule'),
            'website' => Yii::t('backend', 'Website'),
            'email' => Yii::t('backend', 'Email'),
            'phones' => Yii::t('backend', 'Phones'),
            'phones_comment' => Yii::t('backend', 'Phones Comment'),
        ];
    }

    public function uploadJsonFile()
    {
        if ($this->validate()) {
            $path = Yii::getAlias('@storage') . '/json/' . $this->jsonFile->baseName . '.' . $this->jsonFile->extension;
            $this->jsonFile->saveAs($path, false);
            // var_dump($path); die;
            // @unlink($path);
            return $path;
        } else {
            return false;
        }
    }

    public function Parsing()
    {
        $path = Yii::getAlias('@storage') . '/json/test.json';
        $json = file_get_contents($path, true);
        $array = Json::decode($json, false);

        foreach ($array as $object) {
            $place = new Place();
            if (Place::findOne(['title' => $object->data->general->name]) == null) {
                $place->title = $object->data->general->name;
            }
            $place->description = $object->data->general->description;
            // var_dump($object->data->general->{$model->city_name});die;
            // $place->city_id = $object->data->general->locale->name;
            // 'city_sys_name' => $object->data->general->locale->sysName;
            // 'city_src_id' => $object->data->general->locale->id;
            // $place->street = $object->data->general->{$model->street};
            // $place->street_comment = $object->data->general->address->comment;
            $place->address = $object->data->general->address->fullAddress;
            $place->lat = $object->data->general->address->mapPosition->coordinates[0];
            $place->lng = $object->data->general->address->mapPosition->coordinates[1];
            $place->type = $object->data->general->category->name;
            $place->keywords = $object->data->general->contacts->website;

            // $place->category_sys_name = $object->data->general->category->sysName;

            // if (!empty($place->gallery = $object->data->general->gallery)) {
            //     foreach ($place->gallery as $image) {
            //         $pathinfo = pathinfo($image->url);
            //         $place->images[] = $pathinfo;
            //         $place->download($image->url, $pathinfo);
            //     }
            //     $imageFiles = $place->images;
            //     $place->save();
            //     $place->uploadImages($imageFiles);
            // };

            if (!empty($image = $object->data->general->image)) {
                $pathinfo = pathinfo($image->url);
                $place->download($image->url, $pathinfo);
                $place->save();
                $place->uploadImage($pathinfo, $image->title);
            }

            // var_dump($place->keywords);
            // die;

            // $place->email = $object->data->general->contacts->email;

            // if (!empty($object->data->general->contacts->phones)) {
            //     foreach ($object->data->general->contacts->phones as $phone) {
            //         $res[] = [
            //             'phones' => $phone->value,
            //             'phones_comment' => $phone->comment,
            //         ];
            //     }
            // }
            if (!empty($object->data->general->tags)) {
                foreach ($object->data->general->tags as $tag) {
                    $tags = [];
                    $tags[] = trim(str_replace("\n", "", strpos($tag->name, '.')));
                }
            }
            // if (!empty($object->data->general->workingSchedule)) {
            //     foreach ($object->data->general->workingSchedule as $dn => $item) {
            //         $res[] = [
            //             'working_schedule' => '{"' . $dn . '":{"from":"'. $item->from .'","to":"'. $item->to .'"}',
            //         ];
            //     }
            // }
        }
        return $place;
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
