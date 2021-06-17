<?php

namespace common\models\query;

use yii\db\ActiveQuery;
use common\models\EventCategory;

/**
 * This is the ActiveQuery class for [[\common\models\EventCategory]].
 *
 * @see \common\models\EventCategory
 */
class EventCategoryQuery extends ActiveQuery
{
    /**
     * @return $this
     */
    public function active()
    {
        $this->andWhere(['status' => EventCategory::STATUS_ACTIVE]);

        return $this;
    }

    /**
     * @return $this
     */
    public function noParents()
    {
        $this->andWhere('{{%event_category}}.parent_id IS NULL');

        return $this;
    }
}
