<?php

namespace app\models;
use Yii;
use yii\helpers\Json;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "vehicle_models".
 *
 * @property int $id
 * @property string $name
 * @property int $make_id
 * @property int $type_id
 *
 * @property VehicleMakes $make
 * @property VehicleTypes $type
 * @property Vehicles[] $vehicles
 */
class VehicleModels extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehicle_models';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'make_id', 'type_id'], 'required'],
            [['make_id', 'type_id'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['make_id'], 'exist', 'skipOnError' => true, 'targetClass' => VehicleMakes::class, 'targetAttribute' => ['make_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => VehicleTypes::class, 'targetAttribute' => ['type_id' => 'id']],
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
            'make_id' => 'Make Name',
            'type_id' => 'Type Name',
        ];
    }

    /**
     * Gets query for [[Make]].
     *
     * @return \yii\db\ActiveQuery
     * 
     */
     public function actionDashboardStats()
    {
        // Get type statistics (grouped by vehicle type)
        $typeStats = VehicleModels::find()
            ->select(['vehicle_types.name as type_name', 'COUNT(*) as count'])
            ->joinWith('type') // assumes you have a 'type' relation in VehicleModels
            ->groupBy('vehicle_models.type_id')
            ->asArray()
            ->all();

        // Get make statistics (grouped by vehicle make)
        $makeStats = VehicleModels::find()
            ->select(['vehicle_makes.name as make_name', 'COUNT(*) as count'])
            ->joinWith('make') // assumes you have a 'make' relation in VehicleModels
            ->groupBy('vehicle_models.make_id')
            ->asArray()
            ->all();

        // Prepare data for JavaScript charts
        $typeLabels = Json::encode(ArrayHelper::getColumn($typeStats, 'type_name'));
        $typeData = Json::encode(ArrayHelper::getColumn($typeStats, 'count'));
        
        $makeLabels = Json::encode(ArrayHelper::getColumn($makeStats, 'make_name'));
        $makeData = Json::encode(ArrayHelper::getColumn($makeStats, 'count'));

        return $this->render('dashboard', [
            'typeStats' => $typeStats,
            'makeStats' => $makeStats,
            'typeLabels' => $typeLabels,
            'typeData' => $typeData,
            'makeLabels' => $makeLabels,
            'makeData' => $makeData,
        ]);
    }
    public function actionDashboard()
{
    // Get total vehicle count
    $totalVehicles = VehicleModels::find()->count();

    // Get type statistics
    $typeStats = VehicleModels::find()
        ->select(['vehicle_types.name as type_name', 'COUNT(*) as count'])
        ->joinWith('type')
        ->groupBy('vehicle_models.type_id')
        ->orderBy(['count' => SORT_DESC])
        ->asArray()
        ->all();

    // Get make statistics
    $makeStats = VehicleModels::find()
        ->select(['vehicle_makes.name as make_name', 'COUNT(*) as count'])
        ->joinWith('make')
        ->groupBy('vehicle_models.make_id')
        ->orderBy(['count' => SORT_DESC])
        ->asArray()
        ->all();

    return $this->render('dashboard', [
        'totalVehicles' => $totalVehicles,
        'typeStats' => $typeStats,
        'makeStats' => $makeStats,
    ]);
}
    public function getMake()
    {
        return $this->hasOne(VehicleMakes::class, ['id' => 'make_id']);
    }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(VehicleTypes::class, ['id' => 'type_id']);
    }

    /**
     * Gets query for [[Vehicles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVehicles()
    {
        return $this->hasMany(Vehicles::class, ['model_id' => 'id']);
    }

}
