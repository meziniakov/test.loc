<?php

namespace backend\modules\parser\models;

use common\models\Organization;
use Yii;
use GuzzleHttp\Client;
use yii\helpers\HtmlPurifier;

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
            [['total_link', 'per_block'], 'integer'],
            [['url'], 'string', 'max' => 500],
            [['uri', 'main_tag', 'tag_name', 'tag_category_title', 'tag_tags', 'tag_phone', 'tag_links', 'tag_reviews', 'tag_city', 'tag_addres', 'tag_image', 'tag_attr_image', 'tag_category', 'tag_description', 'tag_category_description', 'tag_address'], 'string', 'max' => 50],
            [['user_agent'], 'string', 'max' => 500],
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
            'per_block' => 'Per block',
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
        $client = new Client(['base_uri' => $this->uri]);
        $res = $client->request('GET', $url, [
            'headers' => [
                'User-Agent' => $this->user_agent,
                'Content-type' => 'text/html',
                'Accept' => 'text/html',
            ],
            'proxy' => [
                'socks5' => '174.76.48.230:4145',
                // 'http'  => '89.187.177.97:80', // Use this proxy with "http"
                // 'http'  => '172.67.181.40:80', // Use this proxy with "http"
                // 'https' => '51.178.49.77:3131', // Use this proxy with "https",
            ],
            ['http_errors' => false],
            ['connect_timeout' => 2, 'timeout' => 5],
            // 'debug' => true,
        ]);
        // var_dump($url);die;
        $body = $res->getBody();
        $document = \phpQuery::newDocumentHTML($body);
        return $document;
    }

    public function getUrls($array) {
        $i = 0;
        foreach ($array as $elem) {
          if ($i >= 0 && $i < $this->total_link) {
            $urls[] = pq($elem)->attr('href');
          }
          ++$i;
        }
        return $urls;
    }

    public function getPageByLinkFromXml($xml) {
        $xml = simplexml_load_file($xml); //https://turizmrm.ru/sitemap.xml
        $links = [];
            foreach ($xml as $url) {
                if (preg_match("/what-to-visit\/nature|what-to-visit\/culture/", $url->loc)) {
                    $company = new Organization(); //
                    $company->url = $url->loc;
                    // $links[] = $url->loc;
                    try {
                        var_dump($company->url);die;
                        echo "Ok";die;
                    //   $company->save(false);
                    } catch(\yii\db\Exception $e) {
                        // echo "error";
                        }
                }
            }
        // die;
        // var_dump($links);die;

        while(true) {
            $tmp_uniq = md5(uniqid().time());
            Yii::$app->db->createCommand("UPDATE {{organization}} SET tmp_uniq = '{$tmp_uniq}' WHERE date_parsed is null AND tmp_uniq is null LIMIT ".$this->per_block)->execute();
            $companies = Yii::$app->db->createCommand("SELECT url FROM {{organization}} WHERE tmp_uniq = '{$tmp_uniq}'")->queryAll();
            // var_dump($companies[0]['url']);die;
            if (!$companies) {
                echo "All done";
                exit;
            }
            foreach ($companies as $company) {
                $company = Organization::find()->where(['url' => $company['url']])->one();
                $document = $this->getDocument($company->url);
                $company->date_parsed = date('Y-m-d H:i:s');
                $company->name = trim($document->find($this->tag_name)->text());
                $company->address = HtmlPurifier::process($document->find('div.transport-brief > p:eq(0)')->text());
                // var_dump($document->find('div.transport-brief > p:eq(0)')->text());die;
                // $addres = explode(",", substr($document->find('div.transport-brief > p:eq(0)')->text(), 12));
                //   if (is_array($addres)) {
                //     $company->city = $addres[0];
                //   }
                $document->find('.transport-brief')->remove();
                $document->find('.room-3d-popup')->remove();
                $document->find('.transport-link')->remove();
                $company->description = str_replace("\n", "", trim($document->find($this->tag_description)->text()));
                //get images
                $entry = $document->find($this->tag_image);
                if ($entry) {
                    foreach ($entry as $row) {
                        $imageUrl = $this->uri . pq($row)->attr($this->tag_attr_image);
                        $company->images[] = pathinfo($imageUrl);
                        $pathinfo = pathinfo($imageUrl);
                        $company->imageFiles[] = $company->download($imageUrl, $pathinfo);
                    }
                }
                $imageFiles = $company->images;
                $company->tmp_uniq = "";
                $company->update();
                if ($imageFiles) {
                    $company->uploadImages($imageFiles);
                }
            }
        }
        return true;
    }

    private function parseAndSave(array $array) {
        foreach ($array as $company) {
            $company = Organization::find()->where(['url' => $company['url']])->one();
            $document = $this->getDocument($company->url);
            $company->date_parsed = date('Y-m-d H:i:s');
            $company->name = trim($document->find($this->tag_name)->text());
            $company->address = HtmlPurifier::process($document->find('div.transport-brief > p:eq(0)')->text());
            // var_dump($document->find('div.transport-brief > p:eq(0)')->text());die;
            // $addres = explode(",", substr($document->find('div.transport-brief > p:eq(0)')->text(), 12));
            //   if (is_array($addres)) {
            //     $company->city = $addres[0];
            //   }
            $document->find('.transport-brief')->remove();
            $document->find('.room-3d-popup')->remove();
            $document->find('.transport-link')->remove();
            $company->description = str_replace("\n", "", trim($document->find($this->tag_description)->text()));
            //get images
            $entry = $document->find($this->tag_image);
            if ($entry) {
                foreach ($entry as $row) {
                    $imageUrl = $this->uri . pq($row)->attr($this->tag_attr_image);
                    $company->images[] = pathinfo($imageUrl);
                    $pathinfo = pathinfo($imageUrl);
                    $company->imageFiles[] = $company->download($imageUrl, $pathinfo);
                }
            }
            $imageFiles = $company->images;
            $company->tmp_uniq = "";
            $company->update();
            if ($imageFiles) {
                $company->uploadImages($imageFiles);
            }
        }
    }

    public function getItems($array, $model, $find = null) {
        $items = [];
        $i = 0;
        foreach ($array as $item) {
          if ($i >= 0 && $i < $model->total_link) {
            $items[] = empty($model->uri) ? pq($item)->find($find) : $model->uri . pq($item)->find($find);
          }
          ++$i;
        }
        return $items;
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
