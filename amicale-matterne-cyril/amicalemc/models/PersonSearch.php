<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Person;

/**
 * PersonSearch represents the model behind the search form of `app\models\Person`.
 */
class PersonSearch extends Person
{
    public $cityName;
    public $zip;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'cityid'], 'integer'],
            [['lastname', 'firstname', 'birthdate', 'tel', 'email', 'street', 'iban', 'cityName', 'zip'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Person::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'lastname',
                'firstname',
                'birthdate',
                'cityName' => [
                    'asc' => ['city.name' => SORT_ASC],
                    'desc' => ['city.name' => SORT_DESC]
                ],
                'zip' => [
                    'asc' => ['city.zip' => SORT_ASC],
                    'desc' => ['city.zip' => SORT_DESC]
                ],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            $query->joinWith(['city']);
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'birthdate' => $this->birthdate,
        ]);

        // filter by city name
        $query->joinWith(['city' => function ($q){
            $q->where('city.name LIKE "%' . $this->cityName . '%"');
        }]);        
        $query->joinWith(['city' => function ($q){
            $q->where('city.zip LIKE "%' . $this->zip . '%"');
        }]);

        $query->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'firstname', $this->firstname]);

        return $dataProvider;
    }
}
