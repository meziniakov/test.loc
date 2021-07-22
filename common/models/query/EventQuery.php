<?php

namespace common\models\query;

use creocoder\taggable\TaggableQueryBehavior;
use common\models\Event;
/**
 * This is the ActiveQuery class for [[\frontend\models\Event]].
 *
 * @see \frontend\models\Event
 */
class EventQuery extends \yii\db\ActiveQuery
{
    public function behaviors()
    {
        return [
            TaggableQueryBehavior::class,
        ];
    }
    public function parsed()
    {
        return $this->andWhere(['status' => Event::STATUS_PARSED]);
    }
    public function deleted()
    {
        return $this->andWhere(['status' => Event::STATUS_TRASHED]);
    }
    public function edited()
    {
        return $this->andWhere(['status' => Event::STATUS_EDITED]);
    }
    public function published()
    {
        return $this->andWhere(['status' => Event::STATUS_PUBLISHED]);
    }

    /**
     * {@inheritdoc}
     * @return \frontend\models\Event[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \frontend\models\Event|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}