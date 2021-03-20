<?php

namespace common\models\query;

use creocoder\taggable\TaggableQueryBehavior;
use common\models\PlaceCategory;
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
    public function active()
    {
        return $this->andWhere(['status' => PlaceCategory::STATUS_ACTIVE]);
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