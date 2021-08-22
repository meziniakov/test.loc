<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%area}}`.
 */
class m210822_131438_create_area_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%area}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull()->unsigned(),
            'slug' => $this->string(255)->null(),
            'status' => $this->smallInteger(6)->notNull(),
            'type' => $this->string(20)->null(),
            'type_full' => $this->string(20)->null(),
            'region_id' => $this->integer(3)->null(),
            'fias_id' => $this->string(50)->null(),
            'kladr_id' => $this->integer(20)->null(),
        ],'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->addForeignKey(
            'fk-area-region_id',
            'area',
            'region_id',
            'region',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-area-region_id',
            'area'
        );
        $this->dropTable('{{%area}}');
    }
}