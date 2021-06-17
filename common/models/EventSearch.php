<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Event;

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
            [['id', 'ageRestriction', 'isFree', 'category_id', 'place_id', 'city_id', 'published_at', 'created_at', 'updated_at', 'author_id', 'updater_id'], 'integer'],
            [['title', 'slug', 'preview', 'organizer', 'text', 'start', 'end'], 'safe'],
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

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'ageRestriction' => $this->ageRestriction,
            'isFree' => $this->isFree,
            'start' => $this->start,
            'end' => $this->end,
            'category_id' => $this->category_id,
            'place_id' => $this->place_id,
            'city_id' => $this->city_id,
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'author_id' => $this->author_id,
            'updater_id' => $this->updater_id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'preview', $this->preview])
            ->andFilterWhere(['like', 'organizer', $this->organizer])
            ->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}
