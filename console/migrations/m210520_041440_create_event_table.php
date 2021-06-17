<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%event}}`.
 */
class m210520_041440_create_event_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        if(Yii::$app->db->schema->getTableSchema('{{%event}}', true) === null) {
        $this->createTable('{{%event}}', [
            'id' => $this->primaryKey()->unsigned()->notNull(),
            'title' => $this->string(255)->notNull()->unique(),
            'slug' => $this->string(255)->null(),
            'preview' => $this->string()->null(),
            'organizer' => $this->string(),
            'text' => $this->string()->notNull(),
            'ageRestriction' => $this->integer(),
            'isFree' => $this->boolean(),
            'start' => $this->date(),
            'end' => $this->date(),
            'category_id' => $this->integer(),
            'place_id' => $this->integer(),
            'city_id' => $this->integer(11)->null(),
            'published_at' => $this->integer(11)->null(),
            'created_at' => $this->integer(11)->null(),
            'updated_at' => $this->integer(11)->null(),
            'author_id' => $this->integer(11)->null(),
            'updater_id' => $this->integer(11)->null(),
        ],'ENGINE=InnoDB DEFAULT CHARSET=utf8');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%event}}');
    }
}
