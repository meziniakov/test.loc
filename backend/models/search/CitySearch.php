<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\City;
use common\models\Place;
use Yii;

/**
 * PlaceSearch represents the model behind the search form of `common\models\Place`.
 */
class CitySearch extends City
{
    public $placeCount;
    public $eventCount;
    public $events;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['name', 'ascii_name', 'created_at', 'iata', 'ascii_name', 'placeCount', 'eventCount'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = City::find();
        $query->groupBy('city.id')->select(['city.*','(select count(place.id) from place where place.city_id=city.id) placeCount', '(select count(event.id) from event where event.city_id=city.id) eventCount']);
        // $query->groupBy('city.id')->select(['city.*','(select count(event.id) from event where event.city_id=city.id) eventCount']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => ['name' => SORT_ASC],
                'attributes' => ['id', 'name', 'placeCount', 'eventCount'],
            ],
            'pagination' => [
                'pageSize' => Yii::$app->keyStorage->get('backend.show-count'),
            ],
        ]);

        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'ascii_name' => $this->ascii_name,
            'iata' => $this->iata,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'from_unixtime(created_at, "%d.%m.%Y")', $this->created_at]);

        return $dataProvider;
    }

    public function searchByStatus($params, $status, $count)
    {
        $query = City::find()->where(['=', 'status', $status]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'totalCount' => $count,
            'sort' => [
                'defaultOrder' => [
                        'id' => SORT_DESC
                ]
            ],
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'city_id' => $this->city_id,
            'is_home' => $this->is_home,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'from_unixtime(created_at, "%d.%m.%Y")', $this->created_at]);

        return $dataProvider;
    }
}
