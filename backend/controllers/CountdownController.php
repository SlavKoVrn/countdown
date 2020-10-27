<?php
namespace backend\controllers;

use common\models\CountDown;

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
        return json_encode(CountDown::getRest($_GET['id']));
    }
}
