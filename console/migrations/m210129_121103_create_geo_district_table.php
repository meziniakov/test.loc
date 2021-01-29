<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%geo_district}}`.
 */
class m210129_121103_create_geo_district_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = $this->db->tablePrefix . 'geo_district';
        if ($this->db->getTableSchema($table, true) === null) {
            $this->createTable('{{%geo_district}}', [
                'id' => $this->primaryKey()->unsigned()->notNull(),
                'name' => $this->string(255)->notNull(),
            ]);
            // $this->batchInsert('{{%geo_district}}', ['id', 'name'], [
            //   ['1', 'Центральный федеральный округ'],
            //   ['2', 'Южный федеральный округ'],
            //   ['3', 'Северо-западный федеральный округ'],
            //   ['4', 'Дальневосточный федеральный округ'],
            //   ['5', 'Сибирский федеральный округ'],
            //   ['6', 'Уральский федеральный округ'],
            //   ['7', 'Приволжский федеральный округ'],
            //   ['8', 'Северо-Кавказский федеральный округ'],
            // ]);
            }
        }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%geo_district}}');
    }
}
