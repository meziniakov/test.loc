<?php

namespace common\models\query;

use creocoder\taggable\TaggableQueryBehavior;
use common\models\Place;
/**
 * This is the ActiveQuery class for [[\frontend\models\Places]].
 *
 * @see \frontend\models\Places
 */
class PlaceQuery extends \yii\db\ActiveQuery
{
    public function behaviors()
    {
        return [
            TaggableQueryBehavior::class,
        ];
    }
    public function parsed()
    {
        return $this->andWhere(['status' => Place::STATUS_PARSED]);
    }
    public function trashed()
    {
        return $this->andWhere(['status' => Place::STATUS_TRASHED]);
    }
    public function edited()
    {
        return $this->andWhere(['status' => Place::STATUS_EDITED]);
    }
    public function published()
    {
        return $this->andWhere(['status' => Place::STATUS_PUBLISHED]);
    }

    /**
     * {@inheritdoc}
     * @return \frontend\models\Places[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \frontend\models\Places|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}