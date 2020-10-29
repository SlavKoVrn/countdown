<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WorkHoliday */

$this->title = 'Изменить рабочий праздничный день: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Рабочие праздничные дни', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Изменить';
?>
<div class="work-holiday-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
