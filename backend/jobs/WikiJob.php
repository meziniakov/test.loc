<?php
namespace backend\jobs;

use Yii;
use yii\base\BaseObject;
use common\models\City;
use GuzzleHttp\Client;

class WikiJob extends BaseObject implements \yii\queue\JobInterface
{
    public $city;

    public function behaviors()
    {
        return [
            'image' => [
                'class' => 'alex290\yii2images\behaviors\ImageBehave',
            ],
        ];
    }

    public function execute($queue)
    {
        $city_name = $this->city;

        $client = new Client();
        $res = $client->request('GET', 'https://ru.wikipedia.org/w/api.php', [
            'headers' => [
              'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.71 Safari/537.36',
              // 'Content-type' => 'text/html',
              //   'Accept' => 'text/html',
            ],
            'query' => [
              'format' => 'json',
              'action' => 'query',
              'prop' => 'extracts',
              'exintro' => '',
              'extract' => 'explaintext',
              'utf8' => 1,
              'titles' => $city_name
            ],
            ['http_errors' => false],
            ['connect_timeout' => 2, 'timeout' => 5],
        ]);
    
        $body = $res->getBody();
        $document = json_decode($body, true);
    
        foreach($document['query']['pages'] as $item) {
            $preview = strip_tags($item['extract'], '<p>');
        }

        if($city = City::findOne(['name' => $city_name])){
            $city->preview = $preview;
            $city->save(false);
        }
    }
}