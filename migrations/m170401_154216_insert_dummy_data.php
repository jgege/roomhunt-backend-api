<?php

use yii\db\Migration;

class m170401_154216_insert_dummy_data extends Migration
{
    public function safeUp()
    {
        $personData = [
            [
                'name' => 'Name69',
                'picture' => 'something.jpg',
                'url' => 'http://facebook.com',
            ],
            [
                'name' => 'Test Name',
                'picture' => 'something.jpg',
                'url' => 'http://facebook.com',
            ],
            [
                'name' => 'Hello MLH',
                'picture' => 'something.jpg',
                'url' => 'http://facebook.com',
            ],
            [
                'name' => 'Alexa',
                'picture' => 'something.jpg',
                'url' => 'http://facebook.com',
            ],
        ];

        $flatData = [
            [
                'longitude' => '50.0000',
                'latitude' => '55.0000',
                'bedroomNo' => 1,
                'price' => 1000,
            ],
            [
                'longitude' => '50.0000',
                'latitude' => '56.0000',
                'bedroomNo' => 3,
                'price' => 3000,
            ],
            [
                'longitude' => '50.0000',
                'latitude' => '57.0000',
                'bedroomNo' => 5,
                'price' => 3500,
            ],
        ];

        $interestData = [
            ['flat_id' => 1, 'person_id' => 1],
            ['flat_id' => 1, 'person_id' => 2],
            ['flat_id' => 1, 'person_id' => 3],
            ['flat_id' => 2, 'person_id' => 3],
            ['flat_id' => 3, 'person_id' => 1],
            ['flat_id' => 3, 'person_id' => 3],
        ];

        foreach ($personData as $person) {
            $this->insert('{{%person}}', $person);
        }

        foreach ($flatData as $flat) {
            $this->insert('{{%flat}}', $flat);
        }

        foreach ($interestData as $interest) {
            $this->insert('{{%person_interested_in_flat}}', $interest);
        }
    }

    public function safeDown()
    {
        return false;
    }
}
