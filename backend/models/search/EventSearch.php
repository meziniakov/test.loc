<?php

namespace backend\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Event;
use Yii;

/**
 * EventSearch represents the model behind the search form of `common\models\Event`.
 */
class EventSearch extends Event
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'status', 'city_id'], 'integer'],
            [['title', 'text', 'created_at'], 'safe'],
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
        $query = Event::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                        'id' => SORT_DESC
                ]
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
            'category_id' => $this->category_id,
            'city_id' => $this->city_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'from_unixtime(created_at, "%d.%m.%Y")', $this->created_at]);

        return $dataProvider;
    }

    public function searchByStatus($params, $status, $count)
    {
        $query = Event::find()->with('category', 'city')->where(['=', 'status', $status]);
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
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'from_unixtime(created_at, "%d.%m.%Y")', $this->created_at]);

        return $dataProvider;
    }
}