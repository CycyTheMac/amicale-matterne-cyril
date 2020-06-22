<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "person".
 *
 * @property int $id
 * @property string $lastname
 * @property string $firstname
 * @property string|null $birthdate
 * @property string|null $tel
 * @property string|null $email
 * @property string $street
 * @property string|null $iban
 * @property int $cityid
 *
 * @property AssociationPerson[] $associationPeople
 * @property City $city
 */
class Person extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'person';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lastname', 'firstname', 'street', 'cityid'], 'required'],
            [['birthdate'], 'safe'],
            [['cityid'], 'integer'],
            [['lastname', 'firstname', 'tel', 'email', 'street'], 'string', 'max' => 255],
            [['iban'], 'ibanValidation'],
            [['cityid'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['cityid' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'lastname' => Yii::t('app', 'Lastname'),
            'firstname' => Yii::t('app', 'Firstname'),
            'birthdate' => Yii::t('app', 'Birthdate'),
            'tel' => Yii::t('app', 'Tel'),
            'email' => Yii::t('app', 'Email'),
            'street' => Yii::t('app', 'Street'),
            'iban' => Yii::t('app', 'Iban'),
            'cityid' => Yii::t('app', 'City'),
            'cityName' => Yii::t('app', 'City'),
            'zip' => Yii::t('app', 'Zip'),
        ];
    }

    /**
     * Gets query for [[AssociationPeople]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssociationPeople()
    {
        return $this->hasMany(AssociationPerson::className(), ['personid' => 'id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'cityid']);
    }

    public function getCityName(){
        return $this->city->name;
    }

    public function getZip(){
        return $this->city->zip;
    }

    public function ibanValidation($attribute, $params){
        $ibanToVerify = new IbanNumber($this->iban);
        $wrongIbanError = '';

        if(!$ibanToVerify->Verify()){
            $wrongIbanError .= 'Iban invalide !';
            $suggestions = $ibanToVerify->MistranscriptionSuggestions();
            if(is_array($suggestions)){
                if(count($suggestions) == 1){
                    $wrongIbanError .= ' Voulez-vous dire : ' . $suggestions[0] . '?';
                }
            }
            $this->addError($attribute, $wrongIbanError);
        }
    }
}
