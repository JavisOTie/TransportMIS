<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Vehiclemodels $model */

$this->title = 'Create Vehicle Models';
$this->params['breadcrumbs'][] = ['label' => 'Vehiclemodels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehiclemodels-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
