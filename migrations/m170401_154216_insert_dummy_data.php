<?php

use yii\db\Migration;

class m170401_154216_insert_dummy_data extends Migration
{
    public function safeUp()
    {
        $personData = [
            [
                'name' => 'Adrian Itsa Xu',
                'picture' => 'adrian.jpg',
                'url' => 'https://facebook.com/itsa.xu',
            ],
            [
                'name' => 'Harris Mirza',
                'picture' => 'harris.jpg',
                'url' => 'https://facebook.com/harris.mirza212',
            ],
            [
                'name' => 'Gergely Juhasz',
                'picture' => 'gege.jpg',
                'url' => 'https://facebook.com/juhaszgege',
            ],
            [
                'name' => 'Milan Gh',
                'picture' => 'milan.jpg',
                'url' => 'https://facebook.com/ThelFear',
            ],
        ];

        $flatData = [
            [
                'latitude' => '51.520551',
                'longitude' => '-0.087564',
                'bedroomNo' => 1,
                'price' => 1000,
            ],
            [
                'latitude' => '51.521212',
                'longitude' => '-0.085697',
                'bedroomNo' => 3,
                'price' => 3000,
            ],
            [
                'latitude' => '51.519873',
                'longitude' => '-0.087096',
                'bedroomNo' => 5,
                'price' => 3500,
            ],
            [
                'latitude' => '51.519652',
                'longitude' => '-0.089402',
                'bedroomNo' => 4,
                'price' => 10000,
            ],
            [
                'latitude' => '51.520453',
                'longitude' => '-0.090132',
                'bedroomNo' => 3,
                'price' => 2000,
            ],
            [
                'latitude' => '51.520834',
                'longitude' => '-0.089284',
                'bedroomNo' => 2,
                'price' => 4000,
            ],
            [
                'latitude' => '51.521143',
                'longitude' => '-0.090098',
                'bedroomNo' => 2,
                'price' => 1000,
            ],
            [
                'latitude' => '51.521897',
                'longitude' => '-0.086686',
                'bedroomNo' => 5,
                'price' => 3500,
            ],
            [
                'latitude' => '51.520061',
                'longitude' => '-0.084937',
                'bedroomNo' => 1,
                'price' => 300,
            ],
            [
                'latitude' => '51.518993',
                'longitude' => '-0.085806',
                'bedroomNo' => 2,
                'price' => 4000,
            ],
            [
                'latitude' => '51.518659',
                'longitude' => '-0.086332',
                'bedroomNo' => 4,
                'price' => 4000,
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
