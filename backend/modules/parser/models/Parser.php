<?php

namespace backend\modules\parser\models;

use Yii;
use GuzzleHttp\Client;


/**
 * This is the model class for table "parser".
 *
 * @property int $id
 * @property string $uri
 * @property string $main_tag
 * @property int $total_link
 * @property string $user_agent
 * @property string $tag_name
 * @property string $tag_description
 * @property string $tag_city
 * @property string $tag_addres
 * @property string $tag_image
 * @property string $tag_attr_image
 * @property string $tag_category
 * @property string $tag_category_title
 * @property string $tag_category_description
 * @property string $tag_tags
 * @property string $tag_phone
 * @property string $tag_links
 * @property string $tag_reviews
 */
class Parser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parser';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uri', 'main_tag', 'url'], 'required'],
            [['total_link'], 'integer'],
            [['url'], 'string', 'max' => 500],
            [['uri', 'main_tag', 'tag_name', 'tag_category_title', 'tag_tags', 'tag_phone', 'tag_links', 'tag_reviews', 'tag_city', 'tag_addres', 'tag_image', 'tag_attr_image', 'tag_category', 'user_agent', 'tag_description', 'tag_category_description', 'tag_address'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uri' => 'Uri',
            'url' => 'Url',
            'main_tag' => 'Main Tag',
            'total_link' => 'Total Link',
            'user_agent' => 'User Agent',
            'tag_name' => 'Tag Name',
            'tag_description' => 'Tag Description',
            'tag_city' => 'Tag City',
            'tag_addres' => 'Tag Addres',
            'tag_image' => 'Tag Image',
            'tag_attr_image' => 'Tag Attr Image',
            'tag_category' => 'Tag Category',
            'tag_category_title' => 'Tag Category Title',
            'tag_category_description' => 'Tag Category Description',
            'tag_tags' => 'Tag Tags',
            'tag_phone' => 'Tag Phone',
            'tag_links' => 'Tag Links',
            'tag_reviews' => 'Tag Reviews',
            'tag_address' => 'Tag Address',
        ];
    }

    public function getDocument($url) {
        $client = new Client();
        $res = $client->request('GET', $url);
        $body = $res->getBody();
        $document = \phpQuery::newDocumentHTML($body);
        return $document;
    }

    public function getUrls($productsList, $model) {
        $urls = [];
        $i = 0;
        foreach ($productsList as $elem) {
          if ($i >= 0 && $i < $model->total_link) {
            $urls[] = empty($model->uri) ? pq($elem)->attr('href') : $model->uri . pq($elem)->attr('href');
          }
          ++$i;
        }
        return $urls;
    }


    public function afterSave($insert, $changedAttributes) {
        if ($insert) {
            Yii::$app->session->setFlash('success', 'Запись добавлена');
        } else {
            Yii::$app->session->setFlash('success', 'Запись обновлена');
        }
        parent::afterSave($insert, $changedAttributes);
    }
}
