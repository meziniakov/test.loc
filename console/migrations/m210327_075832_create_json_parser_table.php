<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%json_parser}}`.
 */
class m210327_075832_create_json_parser_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%json_parser}}', [
            'id' => $this->primaryKey()->unsigned()->notNull(),
            'src_id' => $this->string(20),
            'name' => $this->string(20)->notNull(),
            'description' => $this->string(20),
            'city_name' => $this->string(20),
            'city_sys_name' => $this->string(20),
            'city_sys_name' => $this->string(20),
            'city_src_id' => $this->string(20),
            'street' => $this->string(20),
            'street_comment' => $this->string(20),
            'full_address' => $this->string(20),
            'lat' => $this->string(50),
            'lng' => $this->string(50),
            'category_name' => $this->string(20),
            'category_sys_name' => $this->string(20),
            'image_url' => $this->string(20),
            'image_alt' => $this->string(20),
            'gallery_url' => $this->string(20),
            'gallery_alt' => $this->string(20),
            'tag_name' => $this->string(20),
            'tag_sys_name' => $this->string(20),
            'working_schedule' => $this->string(20),
            'website' => $this->string(20),
            'email' => $this->string(20),
            'phones' => $this->string(20),       
            'phones_comment' => $this->string(20),       
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%json_parser}}');
    }
}
