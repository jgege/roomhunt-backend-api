<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use Yii;

/**
 * This is the model class for table "flat".
 *
 * @property int $id
 * @property string $latitude
 * @property string $longitude
 * @property int $bedroomNo
 * @property int $price
 * @property int $updated_at
 * @property int $created_at
 *
 * @property PersonInterestedInFlat[] $personInterestedInFlats
 */
class Flat extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%flat}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['latitude', 'longitude'], 'number'],
            [['bedroomNo', 'price'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'bedroomNo' => 'Bedroom No',
            'price' => 'Price',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    public function getPersons()
    {
        return $this->hasMany(Person::className(), ['id' => 'person_id'])
        ->via('personInterestedInFlats');
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPersonInterestedInFlats()
    {
        return $this->hasMany(PersonInterestedInFlat::className(), ['flat_id' => 'id']);
    }
}