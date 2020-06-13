<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\City;

/**
 * CitySearch represents the model behind the search form of `app\models\City`.
 */
class CitySearch extends City
{
    // Calculate attribute
    public $countryName;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
        [['id', /*'is_subcity', 'countryid'*/], 'integer'],
            [['zip', 'name', 'countryName'], 'safe'],
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
        $query = City::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        // Setup sorting attributes
        $dataProvider->setSort([
            'attributes' => [
                // 'id',
                'zip',
                'name',
                // 'is_subcity',
                // 'countryid',
                'countryName' => [
                    'asc' => ['country.name' => SORT_ASC],
                    'desc' => ['country.name' => SORT_DESC]
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            $query->joinWith(['country']);
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            // 'is_subcity' => $this->is_subcity,
            // 'countryid' => $this->countryid,
        ]);
        
        // filter by country name
        $query->joinWith(['country' => function ($q){
            $q->where('country.name LIKE "%' . $this->countryName . '%"');
        }]);

        $query->andFilterWhere(['like', 'zip', $this->zip])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
