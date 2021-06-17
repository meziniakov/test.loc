<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%event_category}}`.
 */
class m210530_123145_create_event_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%event_category}}', [
            'id' => $this->primaryKey()->unsigned()->notNull(),
            'title' => $this->string(255)->notNull()->unique(),
            'slug' => $this->string(255)->null(),
            'parent_id' => $this->integer(10)->null(),
            'status' => $this->smallInteger(6)->notNull(),
            'created_at' => $this->integer(11)->null(),
            'updated_at' => $this->integer(11)->null(),
        ]);
        // $this->addForeignKey(
        //     'fk_event_category_section',  // это "условное имя" ключа
        //     'event_category', // это название текущей таблицы
        //     'parent_id', // это имя поля в текущей таблице, которое будет ключом
        //     'event_category', // это имя таблицы, с которой хотим связаться
        //     'id', // это поле таблицы, с которым хотим связаться
        //     'CASCADE'
        // );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%event_category}}');
        // $this->dropForeignKey(
        //     'fk_event_category_section',
        //     'event_category'
        // );
    }
}
