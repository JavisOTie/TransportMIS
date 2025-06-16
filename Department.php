<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Department $model */
/** @var ActiveForm $form */
?>
<div class="Department">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'status') ?>
        <?= $form->field($model, 'dept_code') ?>
        <?= $form->field($model, 'dept_name') ?>
        <?= $form->field($model, 'fac_code') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- Department -->
