<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vehicle_makes".
 *
 * @property int $id
 * @property string $name
 *
 * @property VehicleModels[] $vehicleModels
 */
class VehicleMakes extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehicle_makes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[VehicleModels]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleModels()
    {
        return $this->hasMany(VehicleModels::class, ['make_id' => 'id']);
    }

}
