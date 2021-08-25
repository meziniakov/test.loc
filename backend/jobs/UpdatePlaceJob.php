<?php
namespace backend\jobs;

use common\models\Area;
use common\models\City;
use common\models\FederalDistrict;
use yii\base\BaseObject;
use common\models\Place;
use common\models\Region;

class UpdatePlaceJob extends BaseObject implements \yii\queue\JobInterface
{
    public $object;
    public $place;

    public function execute($queue)
    {
        
        $object = $this->object;
        // $place = $this->place;
        $place = Place::findOne(['title' => $object->name]);

        $place->title = $object->name;
        $place->src_id = $object->id;
        $place->status = Place::STATUS_UPDATED;
        $place->text = $object->description;
        $place->address = $object->address->fullAddress;
        $place->street = $object->address->street;
        $place->street_comment = $object->address->fiasStreetId;

        $dadata = new \Dadata\DadataClient(env('DADATA_TOKEN'), env('DADATA_SECRET'));
        if(isset($object->address->fiasHouseId)) {
            $response = $dadata->findById("address", $object->address->fiasHouseId);
        } else {
            $response = $dadata->findById("address", $object->address->fiasStreetId);                        
        }

        if(!$federal_district = FederalDistrict::findOne(['name' => $response[0]['data']['federal_district']])) {
            $federal_district = new FederalDistrict();
            $federal_district->name = $response[0]['data']['federal_district'];
            $federal_district->country_id = 1;
            if($federal_district->validate()){
                $federal_district->save();
            }
        }
        if(!$region = Region::findOne(['name' => $response[0]['data']['region']])) {
            $region = new Region();
            $region->federal_district_id = $federal_district->id;
            $region->name = $response[0]['data']['region'];
            $region->type = $response[0]['data']['region_type'];
            $region->type_full = $response[0]['data']['region_type_full'];
            if($region->validate()){
                $region->save();
            }
        }
        if(!$area = Area::findOne(['name' => $response[0]['data']['area']])) {
            $area = new Area();
            $area->region_id = $region->id;
            $area->name = $response[0]['data']['area'];
            $area->type = $response[0]['data']['area_type'];
            $area->type_full = $response[0]['data']['area_type_full'];
            $area->validate();
            $area->save();
    }

        if(!empty($response[0]['data']['city'])) {
            if ($city = City::findOne(['name' => $response[0]['data']['city']])) {
                $place->city_id = $city->id;
                $city->area_id = $area->id;
            } else {
                $city = new City();
                $city->name = $response[0]['data']['city'];
                $city->area_id = $area->id;
                // $city->url = $object->locale->sysName;
                $city->validate();
                $city->save();
                $place->city_id = $city->id;
            }
        } else {
            $city = new City();
            $city->name = $response[0]['data']['settlement_with_type'];
            $city->area_id = $area->id;
            // $city->url = $object->locale->sysName;
            $city->save();
            $place->city_id = $city->id;
        }

        // Если в массиве есть поле с tags, перебираем их и забираем данные
        if (isset($object->tags)) {
            $tags = [];
            foreach ($object->tags as $tag) {
                $tags[] = $tag->name;
            }
            $place->addTagValues($tags);
        }

        $place->save();
    }
}