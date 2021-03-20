<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%city}}`.
 */
class m210301_181351_create_city_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(Yii::$app->db->schema->getTableSchema('{{%city}}', true) === null) {
            $this->createTable('{{%city}}', [
                'id' => $this->primaryKey(),
                'name' => $this->string(255)->notNull(),
                'url' => $this->string(255)->notNull(),
            ],'ENGINE=InnoDB DEFAULT CHARSET=utf8'
            );
        }

        $this->batchInsert('city', ['name', 'url'], [
            ['Темников', 'temnikov'],
            ['Саранск', 'saransk'],
        ]);
    }
    

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%city}}');
    }
}
