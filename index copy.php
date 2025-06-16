<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Vehicles;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

/** @var yii\web\View $this */
/** @var app\models\VehiclesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Vehicles';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="vehicles-index">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= Html::encode($this->title) ?></h1>
        <div>
            <?= Html::a('Create Vehicle', ['create'], ['class' => 'btn btn-success me-2']) ?>
            <div class="d-inline-block">
                <h5 class="d-inline-block me-2 mb-0 align-middle">Generate Document</h5>
                <!-- </?= ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                    // 'exportConfig' => [
                    //     ExportMenu::FORMAT_CSV => false,
                    //     ExportMenu::FORMAT_HTML => false,
                    //     ExportMenu::FORMAT_EXCEL => false,
                    //     ExportMenu::FORMAT_TEXT => false,
                    // ],
                    'columns' => [
                        ['class' => 'kartik\grid\SerialColumn'],
                        'registration_no',
                        'year_manufacture',
                        'color',
                        'seating_capacity',
                        'model_id',
                        [
                            'attribute' => 'vpic',
                            'format' => 'raw',
                        ],
                    ],
                    // 'dropdownOptions' => [
                    //     'label' => '<i class="fas fa-file-export"></i>',
                    //     'class' => 'btn btn-primary',
                    //     'title' => 'Export Options'
                    // ],
                    // 'fontAwesome' => true,
                    // 'asDropdown' => true,
                    // 'showConfirmAlert' => false,
                ]) ?> -->
            </div>
        </div>
    </div>

    <?= GridView::widget([
        'headerRowOptions' => ['class' => 'kartik-sheet-style grid-header'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style grid-header'],
        'pjax' => false,
        'export' => false,
        'responsiveWrap' => false,
        'condensed' => true,
        'hover' => true,
        'striped' => false,
        'bordered' => false,
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            'registration_no',
            'year_manufacture',
            'color',
            'seating_capacity',
            'model_id',
            [
                'attribute' => 'vpic',
                'format' => 'html',
                'value' => function ($model) {
                    $imagePath = $model->vpic;
                    return Html::img(Yii::$app->urlManager->createUrl([$imagePath]), ['style' => 'width: 80px; height: 60px;']);
                },
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'header' => 'Actions',
                'template' => '{update}{view}{delete}',
                'contentOptions' => [
                    'style' => 'white-space: nowrap; width: 30%;',
                    'class' => 'kartik-sheet-style kv-align-middle',
                ],
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        return Html::a('<i class="fas fa-trash"></i> Delete', 
                        Url::to(['vehicles/delete', 'registration_no' => $model->registration_no ]),
                        [
                            'title' => 'Delete',
                            'data-confirm' => 'Are you sure you want to delete this item?',
                            'data-method' => 'post', 
                            'class' => 'btn btn-md text-center btn-outline-danger manage-button',
                            'style' => 'hover:green; margin-right: 8px; border:1px solid #2a68af; border-radius:4px; !important;',
                        ]);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a(
                            '<i class="bi bi-pencil-square"></i> Update',
                            [
                                'vehicles/update',
                                'registration_no' => $model->registration_no 
                            ],
                            [
                                'class' => 'btn btn-md btn-outline-info text-center manage-button',
                                'style' => 'hover:green; margin-right: 8px; border:1px solid #2a68af; border-radius:4px; !important;',
                            ]
                        );
                    },
                    'view' => function ($url, $model, $key) {
                        return Html::a(
                            '<i class="bi bi-view"></i> View',
                            [
                                'vehicles/view',
                                'registration_no' => $model->registration_no 
                            ],
                            [
                                'class' => 'btn btn-md text-center manage-button',
                                'style' => 'hover:green; margin-right: 8px; border:1px solid #2a68af; border-radius:4px; !important; display:none;',
                            ]
                        );
                    },
                ],
            ],
        ],
    ]) ?>

</div>