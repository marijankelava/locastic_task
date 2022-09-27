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

                $totalTime[] = strtotime($runner);
                
                $avg = array_sum($totalTime) / count($totalTime);

                $avgMedium = date('H:i:s',$avg);    
            }
            //dd($avgMedium);
        return $avgMedium;
    }

    public function averageLongTime($longResults)
    {
        foreach($longResults as $time){
        $timeArray[] = $time['raceTime'];
        }
            foreach($timeArray as $runner){
                
                $totalTime[] = strtotime($runner);
                
                $avg = array_sum($totalTime) / count($totalTime);
                
                $avgLong = date('H:i:s',$avg);
            }
            //dd($avgLong);
        return $avgLong;
    }
}