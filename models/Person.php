<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use Yii;

/**
 * This is the model class for table "person".
 *
 * @property int $id
 * @property string $name
 * @property string $picture
 * @property string $url
 * @property int $updated_at
 * @property int $created_at
 * @property PersonInterestedInFlat[] $personInterestedInFlats 
 */
class Person extends \yii\db\ActiveRecord
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
        return 'person';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['updated_at', 'created_at'], 'integer'],
            [['name', 'picture', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'picture' => 'Picture',
            'url' => 'Url',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPersonInterestedInFlats()
    {
        return $this->hasMany(PersonInterestedInFlat::className(), ['person_id' => 'id']);
    }
}