<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vehicle_allocation".
 *
 * @property int $allocation_id
 * @property string $dept_code
 * @property string $registration_no
 * @property string $allocation_date
 * @property string|null $return_date
 * @property string|null $remarks
 */
class VehicleAllocation extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehicle_allocation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['return_date', 'remarks'], 'default', 'value' => null],
            [['dept_code', 'registration_no', 'allocation_date'], 'required'],
            [['allocation_date', 'return_date'], 'safe'],
            [['dept_code'], 'string', 'max' => 11],
            [['registration_no'], 'string', 'max' => 20],
            [['remarks'], 'string', 'max' => 200],
            [['dept_code'], 'exist', 'skipOnError' => true, 'targetClass' => Department::class, 'targetAttribute' => ['dept_code' => 'dept_code']],
             [['allocation_status'], 'in', 'range' => ['allocated', 'withdrawn']],
               [['allocation_status'], 'validateAllocationStatus'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'allocation_id' => 'Allocation ID',
            'dept_code' => 'Department',
            'registration_no' => 'Registration No',
            'allocation_date' => 'Allocation Date',
            'return_date' => 'Return Date',
            'remarks' => 'Remarks',
            'allocation_status' => 'Allocation Status',
        ];
    }


       /**
     * Gets query for [[FacCode]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDeptCode()
    {
        return $this->hasOne(Department::class, ['dept_code' => 'dept_code']);
    }

    
public function validateAllocationStatus($attribute, $params)
{
    if ($this->allocation_status == 'withdrawn') {
        if (!$this->existsAllocation()) {
            $this->addError($attribute, 'Cannot withdraw a vehicle that is not allocated.');
        }
    }
}
public function existsAllocation()
{
    return self::find()
        ->where(['registration_no' => $this->registration_no, 'allocation_status' => 'allocated'])
        ->exists();
}
    
}
