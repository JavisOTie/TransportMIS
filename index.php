<?php

use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\grid\ActionColumn;
use app\models\VehicleModels;
use kartik\export\ExportMenu;

/** @var yii\web\View $this */
/** @var app\models\Search\VehiclemodelsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Vehicle Models';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    
</style>
<div class="vehiclemodels-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Vehicle Models', ['create'], ['class' => 'btn btn-success']) ?>
            <h5 class="d-inline-block me-2 mb-0 align-middle">Generate Document</h5>
            <?php
         echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'exportConfig' => [
            ExportMenu::FORMAT_CSV =>  false,
    ExportMenu::FORMAT_HTML =>  false,
    ExportMenu::FORMAT_EXCEL =>  false,
    ExportMenu::FORMAT_TEXT =>  false,
    ],

    'columns' =>[
        'name',
    ],
]);
        ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
     GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            
           // 'id',
            'name',
           //'make_id',
           // 'type_id',
          //start
    // 'value' => function ($model) {
    //    return Url::toRoute([$action, 'id' => $model->id]);  
    // },
            //'id',
           // 'name',
           //'make_id',
           // 'type_id',
          //start
            [
                'class' => 'kartik\grid\ActionColumn',

                'header' => '',

                'template' => '{update}{delete}{view}',
                'contentOptions' => [
                    'style' => 'white-space: nowrap; width: 30%;',
                    'class' => 'kartik-sheet-style kv-align-middle',
                ],
                'buttons' => [
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-trash"></i> Delete', 
                    Url::to(['vehiclemodels/delete', 'id' => $model->id ]),
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
                                'vehiclemodels/update',
                                 'id' => $model->id
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
                                'vehiclemodels/view',
                                 'id' => $model->id
                            ],
                            [
                                'class' => 'btn btn-md text-center manage-button',
                                'style' => 'hover:green; margin-right: 8px; border:1px solid #2a68af; border-radius:4px; !important; display:none;',
                              

                           
                            ]
                        );
                    },
                ],
            ],  
            // [
            //     'class' => ActionColumn::className(),
            //     'urlCreator' => function ($action, Vehiclemodels $model, $key, $index, $column) {
            //         return Url::toRoute([$action, 'id' => $model->id]);
            //      }
            // ],
        ],
    ]);
    
    ?>


</div>
