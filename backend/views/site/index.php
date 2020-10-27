<?php
use common\widgets\CountdownWidget;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-md-6">
                <h2>NYSE (New York)</h2>
                <?= CountdownWidget::widget([
                    'id'=>'nyse',
                    'stock'=>'NYSE',
                ]) ?>

            </div>
            <div class="col-md-6">
                <h2>TSE / TYO (Tokyo)</h2>
                <?= CountdownWidget::widget([
                    'id'=>'tse',
                    'stock'=>'TSE/TYO',
                ]) ?>

            </div>
        </div>

    </div>
</div>
