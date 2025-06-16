<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Vehicletypes $model */
/** @var ActiveForm $form */
?>
<div class="Vehicletypes">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- Vehicletypes -->
