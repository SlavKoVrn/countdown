<?php
use common\widgets\CountdownWidget;
use common\models\StockExchange;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-md-6">
                <h2><?= StockExchange::STOCK_EXCHANGE['nyse']['name'].' ('.StockExchange::STOCK_EXCHANGE['nyse']['city'].')' ?></h2>
                <?= CountdownWidget::widget([ 'id'=>'nyse' ]) ?>
            </div>
            <div class="col-md-6">
                <h2><?= StockExchange::STOCK_EXCHANGE['tse']['name'].' ('.StockExchange::STOCK_EXCHANGE['tse']['city'].')' ?></h2>
                <?= CountdownWidget::widget([ 'id'=>'tse']) ?>
            </div>
        </div>

    </div>
</div>
