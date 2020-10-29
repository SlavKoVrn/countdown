<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\WorkHoliday */

$this->title = 'Добавить рабочий праздничный день';
$this->params['breadcrumbs'][] = ['label' => 'Рабочие праздничные дни', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-holiday-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
