<?php

namespace common\models\query;

use yii\db\ActiveQuery;
use common\models\CompanyCategory;

/**
 * This is the ActiveQuery class for [[\common\models\CompanyCategory]].
 *
 * @see \common\models\CompanyCategory
 */
class CompanyCategoryQuery extends ActiveQuery
{
    /**
     * @return $this
     */
    public function active()
    {
        $this->andWhere(['status' => CompanyCategory::STATUS_ACTIVE]);

        return $this;
    }

    /**
     * @return $this
     */
    public function noParents()
    {
        $this->andWhere('{{%company_category}}.parent_id IS NULL');

        return $this;
    }
}
