<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CashBox;

/**
 * CashBoxSearch represents the model behind the search form of `common\models\CashBox`.
 */
class CashBoxSearch extends CashBox
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'box_type', 'venue_id', 'currency_id'], 'integer'],
            [['name', 'code', 'details', 'created_at', 'updated_at'], 'safe'],
            [['initial_amount'], 'number'],
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
        $query = CashBox::find();

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
            'box_type' => $this->box_type,
            'venue_id' => $this->venue_id,
            'currency_id' => $this->currency_id,
            'initial_amount' => $this->initial_amount,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'details', $this->details]);

        return $dataProvider;
    }
}
