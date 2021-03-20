<?php

namespace common\models\query;

use yii\db\ActiveQuery;
use common\models\PlaceCategory;

/**
 * This is the ActiveQuery class for [[\common\models\PlaceCategory]].
 *
 * @see \common\models\PlaceCategory
 */
class PlaceCategoryQuery extends ActiveQuery
{
    /**
     * @return $this
     */
    public function active()
    {
        return $this->andWhere(['status' => PlaceCategory::STATUS_ACTIVE]);
    }

    /**
     * @return $this
     */
    public function noParents()
    {
        $this->andWhere('{{%place_category}}.parent_id IS NULL');

        return $this;
    }
}
