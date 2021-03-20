<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%organization}}`.
 */
class m210129_135613_add_is_home_column_to_organization_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    const DB_TABLE = '{{%organization}}';
    
    public function safeUp()
    {
        if(Yii::$app->db->schema->getTableSchema(self::DB_TABLE, true) === null) {
            $this->addColumn('{{%organization}}', 'is_home', $this->integer());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%organization}}', 'is_home');
    }
}
