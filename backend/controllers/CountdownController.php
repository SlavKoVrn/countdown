<?php
namespace backend\controllers;

use common\models\StockExchange;

use Yii;
use yii\web\Controller;

/**
 * Countdown controller
 */
class CountdownController extends Controller
{
    /**
     * @return string
     */
    public function actionGetRest()
    {
        return json_encode(StockExchange::getCountDownTimeRest($_GET['id']));
    }
}
