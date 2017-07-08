<?php

use yii\db\Migration;

class m170706_143306_chain extends Migration
{
    public function up()
    {
		$this->createTable('chain', [
            'id' => $this->primaryKey(),
			'id_dishes' => $this->integer(),
			'id_ingregient' => $this->integer()
        ]);
		$this->addForeignKey(
            'dishes_to_chain',
            'chain',
            'id_dishes',
            'dishes',
            'id',
            'CASCADE'
        );
		$this->addForeignKey(
            'ingredients_to_chain',
            'chain',
            'id_ingregient',
            'ingredients',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'dishes_to_chain',
            'chain'
        );

        $this->dropForeignKey(
            'ingredients_to_chain',
            'chain'
        );

        $this->dropTable('chain');

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
