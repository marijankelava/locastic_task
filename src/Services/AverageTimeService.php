<?php

namespace App\Services;

final class AverageTimeService
{
    public function averageMediumTime($mediumResults)
    {
        foreach($mediumResults as $time){
        $timeArray[] = $time['raceTime'];
        }
            foreach($timeArray as $runner){
                $runner = explode(':', $runner);
                
                $miliSeconds[] = $runner[0] * 60 * 1000 + $runner[1] * 1000 + $runner[2] * 10;

                $avg = array_sum($miliSeconds) / count($miliSeconds);

                $minutes = (int) floor($avg / 60 /1000);

                $seconds = floor(($avg - ($minutes * 60000)) / 1000);

                if ($seconds < 10) {
                    $seconds = 0 . $seconds;
                }

                $miliSec = ceil(($avg - ($minutes * 60000) - ($seconds * 1000)) / 10);

                $avgMedium = [];

                array_push($avgMedium, $minutes, $seconds, $miliSec);
            }
            //dd(implode(':', $avgMedium));

        return implode(':', $avgMedium);
    }

    public function averageLongTime($longResults)
    {
        foreach($longResults as $time){
        $timeArray[] = $time['raceTime'];
        }
            foreach($timeArray as $runner){
                $runner = explode(':', $runner);
                //dd($runner);
                $miliSeconds[] = $runner[0] * 60 * 1000 + $runner[1] * 1000 + $runner[2] * 10;

                $avg = array_sum($miliSeconds) / count($miliSeconds);

                $minutes = (int) floor($avg / 60 /1000);

                $seconds = floor(($avg - ($minutes * 60000)) / 1000);

                if ($seconds < 10) {
                    $seconds = 0 . $seconds;
                }

                $miliSec = ceil(($avg - ($minutes * 60000) - ($seconds * 1000)) / 10);

                $avgLong = [];

                array_push($avgLong, $minutes, $seconds, $miliSec);
            }
            //dd(implode(':', $avgLong));

        return implode(':', $avgLong);
    }
}