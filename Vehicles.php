<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Vehicles $model */
/** @var ActiveForm $form */
?>
<div class="Vehicles">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'color') ?>
        <?= $form->field($model, 'seating_capacity') ?>
        <?= $form->field($model, 'picture') ?>
        <?= $form->field($model, 'registration_no') ?>
        <?= $form->field($model, 'year_manufacture') ?>
        <?= $form->field($model, 'model_id') ?>
        <?= $form->field($model, 'vpic') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- Vehicles -->
