<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vehicles".
 *
 * @property string $registration_no
 * @property string $year_manufacture
 * @property string|null $color
 * @property int|null $seating_capacity
 * @property int $model_id
 * @property string $vpic
 * @property resource|null $picture
 *
 * @property VehicleModels $model
 */
class Vehiclesd extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehicles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['color', 'seating_capacity', 'picture'], 'default', 'value' => null],
            [['registration_no', 'year_manufacture', 'model_id', 'vpic'], 'required'],
            [['year_manufacture'], 'safe'],
            [['seating_capacity', 'model_id'], 'integer'],
            [['picture'], 'string'],
            [['registration_no'], 'string', 'max' => 20],
            [['color'], 'string', 'max' => 30],
            [['vpic'], 'string', 'max' => 200],
            [['registration_no'], 'unique'],
            [['model_id'], 'exist', 'skipOnError' => true, 'targetClass' => VehicleModels::class, 'targetAttribute' => ['model_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'registration_no' => 'Registration No',
            'year_manufacture' => 'Year Manufacture',
            'color' => 'Color',
            'seating_capacity' => 'Seating Capacity',
            'model_id' => 'Model ID',
            'vpic' => 'Vpic',
            'picture' => 'Picture',
        ];
    }

    /**
     * Gets query for [[Model]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModel()
    {
        return $this->hasOne(VehicleModels::class, ['id' => 'model_id']);
    }

}
