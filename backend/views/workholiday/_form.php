<?php
use common\models\StockExchange;
use common\models\WorkHoliday;

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $model common\models\WorkHoliday */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="work-holiday-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'stock')->dropDownList(StockExchange::getStockExchangeArray()) ?>

    <?= $form->field($model, 'holiday')->dropDownList(WorkHoliday::CHOOSE_DAY_ARRAY) ?>

    <?= $form->field($model, 'createTimeRange')->widget(DateRangePicker::class,[
        'convertFormat'=>true,
        'startAttribute'=>'createTimeStart',
        'endAttribute'=>'createTimeEnd',
        'pluginOptions'=>[
            'timePicker'=>true,
            'timePicker24Hour'=> true,
            'timePickerIncrement'=>1,
            'locale'=>[
                'format'=>'d.m.Y H:i'
            ]
        ]
    ]) ?>

    <?= $form->field($model, 'status')->dropDownList(WorkHoliday::CHOOSE_ENABLED_ARRAY) ?>

    <div class="form-group">
        <?= Html::submitButton('Установить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
