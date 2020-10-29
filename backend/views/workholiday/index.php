<?php
use common\models\StockExchange;
use common\models\WorkHoliday;

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel common\models\WorkHolidaySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Рабочие праздничные дни';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-holiday-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'name',
            [
                'attribute' => 'stock',
                'filter'=>StockExchange::getStockExchangeArray(),
                'value' => function ($model){
                    return StockExchange::STOCK_EXCHANGE[$model->stock]['name'].' ('.StockExchange::STOCK_EXCHANGE[$model->stock]['DateTimeZone'].')';
                }
            ],
            [
                'attribute'=>'begin',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'value' => $searchModel->createTimeStart,
                    'attribute' => 'begin',
                    'pluginOptions' => [
                        'format' => 'dd.mm.yy' ,
                        'Highlight' => true,
                        'todayHighlight' => true,
                        'autoclose'=>true,
                    ]
                ]),
                'value'=>function($model){
                    return date('d.m.Y H:i',strtotime($model->begin));
                }
            ],
            [
                'attribute'=>'end',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'value' => $searchModel->end,
                    'attribute' => 'end',
                    'pluginOptions' => [
                        'format' => 'dd.mm.yy' ,
                        'Highlight' => true,
                        'todayHighlight' => true,
                        'autoclose'=>true,
                    ]
                ]),
                'value'=>function($model){
                    return date('d.m.Y H:i',strtotime($model->end));
                }
            ],
            [
                'attribute' => 'holiday',
                'filter'=>WorkHoliday::CHOOSE_DAY_ARRAY,
                'value' => function ($model){
                    return WorkHoliday::CHOOSE_DAY_ARRAY[$model->holiday];
                }
            ],
            [
                'attribute'=>'status',
                'filter'=>WorkHoliday::CHOOSE_ENABLED_ARRAY,
                'value'=>function($model){
                    return WorkHoliday::CHOOSE_ENABLED_ARRAY[$model->status];
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
