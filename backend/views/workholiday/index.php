<?php
use common\models\StockExchange;
use common\models\WorkHoliday;

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $searchModel common\models\WorkHolidaySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Рабочие праздничные дни';
$this->params['breadcrumbs'][] = $this->title;

$filter = '';
if ((isset($searchModel->begin) and $searchModel->begin>0) or
    (isset($searchModel->end) and $searchModel->end>0)){
    $filter = 'Поиск по дате: ';
    if (isset($searchModel->begin) and $searchModel->begin>0){
        $filter .= 'с '.date('d.m.Y H:i',strtotime($searchModel->begin));
    }
    if (isset($searchModel->end) and $searchModel->end>0){
        $filter .= ' по '.date('d.m.Y H:i',strtotime($searchModel->end));
    }
}
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
        'panel' => [
            'heading'=>$filter,
        ],
        'rowOptions' => function ($model, $key, $index, $grid) {
            if ($model->holiday == 1)
                $style='background:#f6b9b9';
            else
                $style='background:#bef6b9';
            if ($model->status == 0)
                $style='background:#cfcfcf';
            return [
                'style' => $style
            ];
        },
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
                'filter' => DateTimePicker::widget([
                    'model' => $searchModel,
                    'value' => $searchModel->createTimeStart,
                    'attribute' => 'begin',
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd HH:00' ,
                        'Highlight' => true,
                        'todayHighlight' => true,
                        'autoclose'=>true,
                        'readOnly'=>true,
                        'minView' => 1,
                    ]
                ]),
                'value'=>function($model){
                    return date(($model->holiday==WorkHoliday::HOLIDDAY)?'d.m.Y':'d.m.Y H:i',strtotime($model->begin));
                }
            ],
            [
                'attribute'=>'end',
                'filter' => DateTimePicker::widget([
                    'model' => $searchModel,
                    'value' => $searchModel->end,
                    'attribute' => 'end',
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd HH:59' ,
                        'Highlight' => true,
                        'todayHighlight' => true,
                        'autoclose'=>true,
                        'readOnly'=>true,
                        'minView' => 1,
                    ]
                ]),
                'value'=>function($model){
                    return date(($model->holiday==WorkHoliday::HOLIDDAY)?'d.m.Y':'d.m.Y H:i',strtotime($model->end));
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
