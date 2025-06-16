<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Faculty $model */
/** @var ActiveForm $form */
?>
<div class="Faculty">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'fac_code') ?>
        <?= $form->field($model, 'faculty_name') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- Faculty -->
