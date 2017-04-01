<?php

use yii\db\Migration;

/**
 * Handles the creation of table `flat`.
 */
class m170401_141259_create_flat_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable(
            '{{%flat}}',
            [
                'id' => $this->primaryKey(),
                'latitude' => $this->decimal(10, 8),
                'longitude' => $this->decimal(11, 8),
                'bedroomNo' => $this->integer(),
                'price' => $this->integer(),
                'updated_at' => $this->bigInteger(),
                'created_at' => $this->bigInteger(),
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%flat}}');
    }
}
