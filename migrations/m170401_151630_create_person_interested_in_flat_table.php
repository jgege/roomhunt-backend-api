<?php

use yii\db\Migration;

/**
 * Handles the creation of table `person_interested_in_flat`.
 */
class m170401_151630_create_person_interested_in_flat_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableName = '{{%person_interested_in_flat}}';
        $this->createTable($tableName, [
            'person_id' => $this->integer(),
            'flat_id' => $this->integer(),
            'deleted_at' => $this->bigInteger(),
            'updated_at' => $this->bigInteger(),
            'created_at' => $this->bigInteger(),
        ]);

        $this->addPrimaryKey('pk_piif', '{{%person_interested_in_flat}}', ['person_id', 'flat_id']);

        $this->addForeignKey('fk_piif_flat_id', $tableName, 'flat_id', 'flat', 'id');
        $this->addForeignKey('fk_piif_person_id', $tableName, 'person_id', 'person', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%person_interested_in_flat}}');
    }
}
