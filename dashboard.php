<?php
use yii\helpers\Json;
use kartik\grid\GridView;
use yii\web\JsExpression;
?>

<div class="row">
    <!-- Pie Chart for Vehicle Types -->
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Vehicle Distribution by Type</h3>
            </div>
            <div class="box-body">
                <div id="typePieChart" style="height: 300px;"></div>
            </div>
        </div>
    </div>

    <!-- Bar Chart for Vehicle Makes -->
    <div class="col-md-6">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Top Vehicle Makes</h3>
            </div>
            <div class="box-body">
                <div id="makeBarChart" style="height: 300px;"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Data Table -->
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Detailed Statistics</h3>
            </div>
            <div class="box-body">
                <?= GridView::widget([
                    'dataProvider' => new \yii\data\ArrayDataProvider([
                        'allModels' => $makeStats,
                        'pagination' => false,
                    ]),
                    'columns' => [
                        'make_id',
                        'count',
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>

<?php
// Register Chart JS
$this->registerJsFile('https://cdn.jsdelivr.net/npm/chart.js');
$this->registerJs(<<<JS
    // Pie Chart for Types
    new Chart(document.getElementById('typePieChart').getContext('2d'), {
        type: 'pie',
        data: {
            labels: {$typeLabels},
            datasets: [{
                data: {$typeData},
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF']
            }]
        }
    });

    // Bar Chart for Makes
    new Chart(document.getElementById('makeBarChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: {$makeLabels},
            datasets: [{
                label: 'Number of Vehicles',
                data: {$makeData},
                backgroundColor: '#00a65a'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
JS);
?>