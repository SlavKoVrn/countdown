<?php
namespace backend\controllers;

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
        $nyse = strtotime('2020-10-27 18:00:00');
        $nasdaq = strtotime('2020-10-29 22:22:00');
        if ($_GET['id'] == 'nyse'){
            $type='open';
            $miliseconds= ($nyse - time()) * 1000;
        }else{
            $type='close';
            $miliseconds = ($nasdaq - time()) * 1000;
        }
        return json_encode([
            'type'=>$type,
            'miliseconds'=> $miliseconds,
        ]);
    }
}
