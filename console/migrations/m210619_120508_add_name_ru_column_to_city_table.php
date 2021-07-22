<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%city}}`.
 */
class m210619_120508_add_name_ru_column_to_city_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('city', 'name_en', $this->string(50)->after('name'));
        $this->addColumn('city', 'ascii_name', $this->string(20));
        $this->addColumn('city', 'iata', $this->string(10));
        $this->addColumn('city', 'in_obj_phrase', $this->string(20));
        $this->addColumn('city', 'from_obj_phrase', $this->string(20));
        $this->addColumn('city', 'name_prepositional', $this->string(20));
        $this->addColumn('city', 'description', $this->string(255));
        $this->addColumn('city', 'website', $this->string(20));
        $this->addColumn('city', 'status', $this->smallInteger(6));
        $this->addColumn('city', 'created_at', $this->integer(11));
        $this->addColumn('city', 'updated_at', $this->integer(11));
        $this->addColumn('city', 'lat', $this->float(10,6));
        $this->addColumn('city', 'lng', $this->float(10,6));
        $this->addColumn('city', 'youtube_url', $this->string(255));
        $this->addColumn('city', 'preview', $this->string());
        $this->addColumn('city', 'title', $this->string());
        $this->addColumn('city', 'h1', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('city', 'name_en');
        $this->dropColumn('city', 'ascii_name');
        $this->dropColumn('city', 'iata');
        $this->dropColumn('city', 'in_obj_phrase');
        $this->dropColumn('city', 'from_obj_phrase');
        $this->dropColumn('city', 'name_prepositional');
        $this->dropColumn('city', 'description');
        $this->dropColumn('city', 'website');
        $this->dropColumn('city', 'status');
        $this->dropColumn('city', 'created_at');
        $this->dropColumn('city', 'updated_at');
        $this->dropColumn('city', 'lat');
        $this->dropColumn('city', 'lng');
        $this->dropColumn('city', 'youtube_url');
        $this->dropColumn('city', 'preview');
        $this->dropColumn('city', 'title');
        $this->dropColumn('city', 'h1');
    }
}
