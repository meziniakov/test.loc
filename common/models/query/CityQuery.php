<?php

namespace common\models\query;

use yii\db\ActiveQuery;
use common\models\City;
use creocoder\taggable\TaggableQueryBehavior;


/**
 * This is the ActiveQuery class for [[\common\models\User]].
 *
 * @see \common\models\User
 */
class CityQuery extends ActiveQuery
{

    public function behaviors()
    {
        return [
            TaggableQueryBehavior::class,
        ];
    }

    /**
     * @return $this
     */
    public function published()
    {
        $this->andWhere(['status' => City::STATUS_ACTIVE]);

        return $this;
    }
}
