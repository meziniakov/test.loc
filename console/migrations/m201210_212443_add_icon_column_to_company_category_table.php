<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%company_category}}`.
 */
class m201210_212443_add_icon_column_to_company_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%company_category}}', 'icon', $this->string(50));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%company_category}}', 'icon');
    }
}
