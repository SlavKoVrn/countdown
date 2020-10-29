<?php
namespace common\models;

use Yii;
use yii\base\Model;
use DateTimeZone;
use DateTime;
use DateInterval;

/**
 * CountDown stock exchange
 */
class StockExchange extends Model
{
    const STOCK_EXCHANGE_NYSE = 'nyse';
    const STOCK_EXCHANGE_TSE = 'tse';
    const STOCK_EXCHANGE = [
        self::STOCK_EXCHANGE_NYSE => [
            'name' => 'NYSE',
            'city' => 'New York',
            'DateTimeZone' => 'America/New_York',
            'week'=>[
                0 => '00:00:00-00:00:00',
                1 => '09:30:00-16:00:00',
                2 => '09:30:00-16:00:00',
                3 => '09:30:00-16:00:00',
                4 => '09:30:00-16:00:00',
                5 => '09:30:00-16:00:00',
                6 => '00:00:00-00:00:00',
            ],
        ],
        self::STOCK_EXCHANGE_TSE => [
            'name' => 'TSE / TYO',
            'city' => 'Tokyo',
            'DateTimeZone' => 'Asia/Tokyo',
            'week'=>[
                0 => '00:00:00-00:00:00',
                1 => '09:00:00-15:00:00',
                2 => '09:00:00-15:00:00',
                3 => '09:00:00-15:00:00',
                4 => '09:00:00-15:00:00',
                5 => '09:00:00-15:00:00',
                6 => '00:00:00-00:00:00',
            ],
        ],
    ];

    public static function getStockExchangeArray()
    {
        $array = [];
        foreach (self::STOCK_EXCHANGE as $key => $stock){
            $array[$key] = $stock['name'].' ('.$stock['DateTimeZone'].')';
        }
        return $array;
    }

    /**
     * @param $stockExchange
     * @return array
     */
    public static function getCountDownTimeRest($stockExchange):array
    {
        $dateTimeZoneRequest = new DateTimeZone(self::STOCK_EXCHANGE[$stockExchange]['DateTimeZone']);
        $dateTimeZoneMoscow = new DateTimeZone('Europe/Moscow');
        $dateTimeRequest = new DateTime("now", $dateTimeZoneRequest);

        $type = '';
        $miliseconds = 0;
        $moscow = '';
        $tempDateTime = clone $dateTimeRequest;
        $step = 0;
        $first = true;
        while (true){
            $today = getdate(strtotime($tempDateTime->format('Y-m-d H:i:s')));
            $work = self::STOCK_EXCHANGE[$stockExchange]['week'][$today['wday']];
            list($begin_time,$end_time) = explode('-',$work);
            $begin = explode(':',$begin_time);
            $end = explode(':',$end_time);
            $begin_datetime = clone $tempDateTime;
            $begin_datetime->setTime($begin[0],$begin[1],$begin[2]);
            $end_datetime = clone $tempDateTime;
            $end_datetime->setTime($end[0],$end[1],$end[2]);
            if ($first){
                $first = false;
                if ($tempDateTime >= $begin_datetime and $tempDateTime <= $end_datetime){
                    $type= 'open';
                    $miliseconds = ($end_datetime->getTimestamp() - $dateTimeRequest->getTimestamp()) * 1000;
                    $moscow = $end_datetime->setTimezone($dateTimeZoneMoscow);
                    break;
                }else{
                    $type= 'closed';
                    if ($tempDateTime < $begin_datetime){
                        $miliseconds = ($begin_datetime->getTimestamp() - $dateTimeRequest->getTimestamp()) * 1000;
                        $moscow = $begin_datetime->setTimezone($dateTimeZoneMoscow);
                        break;
                    }
                }
            }
            $tempDateTime->add(new DateInterval('P1D'));
            $today = getdate(strtotime($tempDateTime->format('Y-m-d H:i:s')));
            $work = self::STOCK_EXCHANGE[$stockExchange]['week'][$today['wday']];
            list($begin_time,$end_time) = explode('-',$work);
            $begin = explode(':',$begin_time);
            $begin_datetime = clone $tempDateTime;
            $begin_datetime->setTime($begin[0],$begin[1],$begin[2]);
            if ($begin_time == $end_time){
                $step++;
                continue;
            }else{
                $miliseconds = ($step * 24 * 3600) + ($begin_datetime->getTimestamp() - $dateTimeRequest->getTimestamp()) * 1000;
                $moscow = $begin_datetime->setTimezone($dateTimeZoneMoscow);
                break;
            }
        }

        return [
            'type'=>$type,
            'miliseconds'=> $miliseconds,
            'moscow'=>$moscow->format('d.m.Y H:i:s'),
        ];
    }
}
