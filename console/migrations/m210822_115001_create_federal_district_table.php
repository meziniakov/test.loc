<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%federal_district}}`.
 */
class m210822_115001_create_federal_district_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%federal_district}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->unsigned()->unique(),
            'slug' => $this->string(255)->null(),
            'status' => $this->smallInteger(6)->notNull(),
            'country_id' => $this->integer(3)->null()
        ],'ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->addForeignKey(
            'fk-federal_district-country_id',
            'federal_district',
            'country_id',
            'country',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%federal_district}}');
        $this->dropForeignKey(
            'fk-federal_district-country_id',
            'federal_district'
        );
    }
}
