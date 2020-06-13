<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "city".
 *
 * @property int $id
 * @property string $zip
 * @property string $name
 * @property int|null $is_subcity
 * @property int $countryid
 *
 * @property Association[] $associations
 * @property Country $country
 * @property Person[] $people
 */
class City extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['zip', 'name'], 'required'],
            [['is_subcity', 'countryid'], 'integer'],
            [['zip'], 'string', 'max' => 25],
            [['name'], 'string', 'max' => 255],
            [['countryid'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['countryid' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'zip' => 'Zip',
            'name' => 'Name',
            'is_subcity' => 'Is Subcity',
            'countryid' => 'Countryid',
            'countryName' => 'Country Name'
        ];
    }

    /**
     * Gets query for [[Associations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssociations()
    {
        return $this->hasMany(Association::className(), ['cityid' => 'id']);
    }

    /**
     * Gets query for [[Country]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'countryid']);
    }

    public function getCountryName()
    {
        return $this->country->name;
    }

    /**
     * Gets query for [[People]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPeople()
    {
        return $this->hasMany(Person::className(), ['cityid' => 'id']);
    }
}
