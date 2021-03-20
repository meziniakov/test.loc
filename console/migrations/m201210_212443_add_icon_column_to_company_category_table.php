<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%place_category}}`.
 */
class m201210_212443_add_icon_column_to_place_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%place_category}}', 'icon', $this->string(50));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%place_category}}', 'icon');
    }
}
