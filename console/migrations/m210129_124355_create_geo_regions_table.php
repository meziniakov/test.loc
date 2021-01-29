<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%geo_regions}}`.
 */
class m210129_124355_create_geo_regions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // $table = $this->db->tablePrefix . 'geo_regions';
        // if ($this->db->getTableSchema($table, true) === null) {
        $this->createTable('{{%geo_regions}}', [
            'id' => $this->primaryKey()->unsigned()->notNull(),
            'district_id' => $this->integer(11)->unsigned()->notNull()->defaultValue(0),
            'name' => $this->string(255)->notNull(),
        ]);
        // $this->batchInsert('{{%geo_regions}}', ['id', 'district_id', 'name'], [
        //     [2, 3, 'Адыгея'],
        //     [3, 6, 'Алтай'],
        // ]);
        // }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%geo_regions}}');
    }
}
