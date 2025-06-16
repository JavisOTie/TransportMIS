<?php

namespace app\models;

use Yii;
use yii\db\Query;
use yii\base\Model;
use yii\db\Expression;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;
use app\models\VehicleAllocation;

/**
 * VehicleAllocationSearch represents the model behind the search form of `app\models\VehicleAllocation`.
 */
class VehicleAllocationSearch extends VehicleAllocation
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['allocation_id'], 'integer'],
            [['dept_code', 'registration_no', 'allocation_date', 'return_date', 'remarks'], 'safe'],
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
        $query = VehicleAllocation::find();

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
            'allocation_id' => $this->allocation_id,
            'allocation_date' => $this->allocation_date,
            'return_date' => $this->return_date,
        ]);

        $query->andFilterWhere(['like', 'dept_code', $this->dept_code])
            ->andFilterWhere(['like', 'registration_no', $this->registration_no])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
    public function faculties($params, $formName = null)
    {
        $sql = "SELECT 
                    faculty.faculty_name,
                    COUNT(vehicle_allocation.registration_no) AS vehicle_count
                FROM vehicle_allocation
           
                INNER JOIN department ON department.dept_code = vehicle_allocation.dept_code
                INNER JOIN faculty ON faculty.fac_code = department.fac_code
                WHERE vehicle_allocation.allocation_status = 'allocated'
                GROUP BY department.fac_code";

        $data = Yii::$app->db->createCommand($sql)->queryAll();

        return new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

    

          return new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
    }


     public function departments($params, $formName = null)
    {
        $sql = "SELECT 
                    department.dept_name,
                    COUNT(vehicle_allocation.registration_no) AS vehicle_count
                FROM vehicle_allocation
                INNER JOIN department ON department.dept_code = vehicle_allocation.dept_code
                -- INNER JOIN faculty ON faculty.fac_code = department.fac_code
                 WHERE vehicle_allocation.allocation_status = 'allocated'
                GROUP BY department.dept_code";

        $data = Yii::$app->db->createCommand($sql)->queryAll();

        // echo "data" . $data->getRawSql;
        // exit();

        return new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

    

        //   return new ArrayDataProvider([
        //     'allModels' => $data,
        //     'pagination' => [
        //         'pageSize' => 10,
        //     ],
        // ]);
    }
}
