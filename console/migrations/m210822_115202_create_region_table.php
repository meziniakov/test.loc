<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%region}}`.
 */
class m210822_115202_create_region_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%region}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->unsigned(),
            'type' => $this->string(20)->null(),
            'type_full' => $this->string(20)->null(),
            'slug' => $this->string(255)->null(),
            'status' => $this->smallInteger(6)->notNull(),
            'federal_district_id' => $this->integer(3)->null(),
            'iso_code' => $this->string(10)->null(),
            'fias_id' => $this->string(50)->null(),
            'kladr_id' => $this->integer(20)->null(),
        ],'ENGINE=InnoDB DEFAULT CHARSET=utf8');
        $this->addForeignKey(
            'fk-region-federal_district_id',
            'region',
            'federal_district_id',
            'federal_district',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%region}}');
        $this->dropForeignKey(
            'fk-region-federal_district_id',
            'region'
        );
    }
}
