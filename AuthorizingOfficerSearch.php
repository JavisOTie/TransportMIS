<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AuthorizingOfficer;

/**
 * AuthorizingOfficerSearch represents the model behind the search form of `app\models\AuthorizingOfficer`.
 */
class AuthorizingOfficerSearch extends AuthorizingOfficer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['authority_id', 'payroll_no'], 'integer'],
            [['dept_code', 'status', 'start_date', 'end_date'], 'safe'],
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
        $query = AuthorizingOfficer::find();

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
            'authority_id' => $this->authority_id,
            'payroll_no' => $this->payroll_no,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);

        $query->andFilterWhere(['like', 'dept_code', $this->dept_code])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
