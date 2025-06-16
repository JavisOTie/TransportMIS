<?php

use yii\helpers\Html;
use app\models\VehicleMake;
use yii\widgets\ActiveForm;
use app\models\Vehicletypes;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\Vehiclemodels $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="vehiclemodels-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>


     <div>
        
            <?= $form->field($model, 'make_id')->dropDownList(
                ArrayHelper::map(VehicleMake::find()->all(), 'id', 'name'),
                ['prompt' => 'Select Make']
            ) ?>
        </div>
     <div>
        
            <?= $form->field($model, 'type_id')->dropDownList(
                ArrayHelper::map(Vehicletypes::find()->all(), 'id', 'name'),
                ['prompt' => 'Select Type']
            ) ?>
        </div>
    <?php // $form->field($model, 'make_id')->textInput() ?>

    <?php // $form->field($model, 'type_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
