<?php
use common\models\StockExchange;
use common\models\WorkHoliday;

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\WorkHoliday */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Рабочие праздничные дни', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="work-holiday-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Удалить день?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            [
                'attribute' => 'stock',
                'value' => function ($model){
                    return StockExchange::STOCK_EXCHANGE[$model->stock]['name'].' ('.StockExchange::STOCK_EXCHANGE[$model->stock]['DateTimeZone'].')';
                }
            ],
            [
                'attribute' => 'holiday',
                'contentOptions' => ['style'=> ($model->holiday == WorkHoliday::HOLIDDAY)?'background:#f6b9b9':'background:#bef6b9'],
                'value' => function ($model){
                    return WorkHoliday::CHOOSE_DAY_ARRAY[$model->holiday];
                }
            ],
            [
                'attribute'=>'begin',
                'value'=>function($model){
                    return date('d.m.Y H:i',strtotime($model->begin));
                }
            ],
            [
                'attribute'=>'end',
                'value'=>function($model){
                    return date('d.m.Y H:i',strtotime($model->end));
                }
            ],
            [
                'attribute'=>'status',
                'contentOptions' => ['style'=> ($model->status == WorkHoliday::ENABLE_DAY)?'':'background:#cfcfcf'],
                'value'=>function($model){
                    return WorkHoliday::CHOOSE_ENABLED_ARRAY[$model->status];
                }
            ],
            [
                'attribute'=>'user',
                'value'=>function($model){
                    return WorkHoliday::getMagager($model->user);
                }
            ],
        ],
    ]) ?>

</div>
