<?php

namespace App\Services;

use App\Entity\Results;

final class TimeService
{ 
    private Results $results;

    public function __construct(Results $results)
    {
        $this->results = $results;
    }

    public function averageTime($times)
    {
        //dd($times);
        foreach($times as $time){
        $timeArray[] = $this->results->getRaceTime($time);
        }
            //dd($timeArray);
            foreach($timeArray as $runner){

                $totalTime[] = strtotime($runner);
                
                $average = array_sum($totalTime) / count($totalTime);

                $avgerage = date('H:i:s',$average);    
            }
            //dd($avgMedium);
        return $average;
    }
}