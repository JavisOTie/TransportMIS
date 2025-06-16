<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "authorizing_officer".
 *
 * @property int $authority_id
 * @property int $payroll_no
 * @property string $dept_code
 * @property string $status active or inactive
 * @property string $start_date
 * @property string|null $end_date
 *
 * @property Department $deptCode
 * @property Staff $payrollNo
 */
class AuthorizingOfficer extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'authorizing_officer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['end_date'], 'default', 'value' => null],
            [['status'], 'default', 'value' => 'ACTIVE'],
            [['payroll_no','start_date'], 'required'],
            [['payroll_no'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['dept_code', 'status'], 'string', 'max' => 11],
            [['dept_code'], 'exist', 'skipOnError' => true, 'targetClass' => Department::class, 'targetAttribute' => ['dept_code' => 'dept_code']],
            // [['payroll_no'], 'exist', 'skipOnError' => true, 'targetClass' => Staff::class, 'targetAttribute' => ['payroll_no' => 'payroll_no']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'authority_id' => 'Authority ID',
            'payroll_no' => 'Payroll No',
            'dept_code' => 'Dept Code',
            'status' => 'Status',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
        ];
    }

    /**
     * Gets query for [[DeptCode]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDeptCode()
    {
        return $this->hasOne(Department::class, ['dept_code' => 'dept_code']);
    }

    // /**
    //  * Gets query for [[PayrollNo]].
    //  *
    //  * @return \yii\db\ActiveQuery
    //  */
    // public function getPayrollNo()
    // {
    //     return $this->hasOne(Staff::class, ['payroll_no' => 'payroll_no']);
    // }

}
