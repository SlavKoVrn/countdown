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
                <h2><?= StockExchange::STOCK_EXCHANGE[StockExchange::STOCK_EXCHANGE_NYSE]['name'].
                    ' ('.StockExchange::STOCK_EXCHANGE[StockExchange::STOCK_EXCHANGE_NYSE]['city'].')' ?></h2>
                <?= CountdownWidget::widget([ 'id'=>StockExchange::STOCK_EXCHANGE_NYSE ]) ?>
            </div>
            <div class="col-md-6">
                <h2><?= StockExchange::STOCK_EXCHANGE[StockExchange::STOCK_EXCHANGE_TSE]['name'].
                    ' ('.StockExchange::STOCK_EXCHANGE[StockExchange::STOCK_EXCHANGE_TSE]['city'].')' ?></h2>
                <?= CountdownWidget::widget([ 'id'=>StockExchange::STOCK_EXCHANGE_TSE]) ?>
            </div>
        </div>

    </div>
</div>
