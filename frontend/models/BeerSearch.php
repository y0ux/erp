<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Beer;

/**
 * BeerSearch represents the model behind the search form of `common\models\Beer`.
 */
class BeerSearch extends Beer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'beer_style_id', 'srm_color_id'], 'integer'],
            [['abv', 'ibu', 'og', 'fg'], 'number'],
            [['aroma', 'flavor', 'created_at', 'updated_at'], 'safe'],
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
        $query = Beer::find();

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
            'product_id' => $this->product_id,
            'beer_style_id' => $this->beer_style_id,
            'abv' => $this->abv,
            'ibu' => $this->ibu,
            'srm_color_id' => $this->srm_color_id,
            'og' => $this->og,
            'fg' => $this->fg,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'aroma', $this->aroma])
            ->andFilterWhere(['like', 'flavor', $this->flavor]);

        return $dataProvider;
    }
}
