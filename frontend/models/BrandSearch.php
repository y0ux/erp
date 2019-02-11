<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Brand;

/**
 * BrandSearch represents the model behind the search form of `common\models\Brand`.
 */
class BrandSearch extends Brand
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['id', 'stand_number', 'negotiation_type', 'status', 'company_id'], 'integer'],
            [['id', 'company_id'], 'integer'],
            //[['name', 'stand_size', 'details', 'created_at', 'updated_at'], 'safe'],
            [['name', 'details', 'created_at', 'updated_at'], 'safe'],
            //[['amount'], 'number'],
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
        $query = Brand::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            //'stand_number' => $this->stand_number,
            //'negotiation_type' => $this->negotiation_type,
            //'status' => $this->status,
            //'amount' => $this->amount,
            'company_id' => $this->company_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            //->andFilterWhere(['like', 'stand_size', $this->stand_size])
            ->andFilterWhere(['like', 'details', $this->details]);

        return $dataProvider;
    }
}
