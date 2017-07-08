<?php

use yii\db\Migration;

class m170706_142926_dishes extends Migration
{
    public function up()
    {
		$this->createTable('dishes', [
            'id' => $this->primaryKey(),
			'name' => $this->string(64),
			'active' => $this->boolean()
        ]);
    }

    public function down()
    {
        $this->dropTable('dishes');

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
