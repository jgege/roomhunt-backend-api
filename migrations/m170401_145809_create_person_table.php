<?php

use yii\db\Migration;

/**
 * Handles the creation of table `person`.
 */
class m170401_145809_create_person_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%person}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'picture' => $this->string(),
            'url' => $this->string(),
            'updated_at' => $this->bigInteger(),
            'created_at' => $this->bigInteger(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%person}}');
    }
}
