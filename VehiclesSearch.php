<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Vehicles;

/**
 * VehiclesSearch represents the model behind the search form of `app\models\Vehicles`.
 */
class VehiclesSearch extends Vehicles
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['registration_no', 'year_manufacture', 'color', 'vpic', 'picture'], 'safe'],
            [['seating_capacity', 'model_id'], 'integer'],
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Vehicles::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'year_manufacture' => $this->year_manufacture,
            'seating_capacity' => $this->seating_capacity,
            'model_id' => $this->model_id,
        ]);

        $query->andFilterWhere(['like', 'registration_no', $this->registration_no])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'vpic', $this->vpic])
            ->andFilterWhere(['like', 'picture', $this->picture]);

        return $dataProvider;
    }
}
