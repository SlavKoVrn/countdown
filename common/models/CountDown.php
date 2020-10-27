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
class CountDown extends Model
{
    const SHEDULE = [
        'nyse'=> [
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
        'tse'=> [
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

    /**
     * @param $stockExchange
     * @return array
     */
    public static function getRest($stockExchange):array
    {
        $dateTimeZoneRequest = new DateTimeZone(self::SHEDULE[$stockExchange]['DateTimeZone']);
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
            $work = self::SHEDULE[$stockExchange]['week'][$today['wday']];
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
            $work = self::SHEDULE[$stockExchange]['week'][$today['wday']];
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
