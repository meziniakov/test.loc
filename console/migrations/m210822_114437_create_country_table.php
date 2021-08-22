<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%country}}`.
 */
class m210822_114437_create_country_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%country}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->unsigned()->unique(),
            'slug' => $this->string(255)->null(),
            'status' => $this->smallInteger(6)->notNull(),
            'iso_code' => $this->string(10)->null()
        ],'ENGINE=InnoDB DEFAULT CHARSET=utf8');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%country}}');
    }
}
