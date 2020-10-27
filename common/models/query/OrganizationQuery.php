<?php

namespace common\models\query;

use creocoder\taggable\TaggableQueryBehavior;

/**
 * This is the ActiveQuery class for [[\frontend\models\Organizations]].
 *
 * @see \frontend\models\Organizations
 */
class OrganizationQuery extends \yii\db\ActiveQuery
{
    public function behaviors()
    {
        return [
            TaggableQueryBehavior::class,
        ];
    }
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \frontend\models\Organizations[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \frontend\models\Organizations|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}