<?php

namespace App\Services;

final class TimeService
{
    public function averageTime($array) : ?string
    {
        $times = [];
        $averageTime = '';
        foreach ($array as $data) {
            $times[] = strtotime($data->getRaceTime());
            $averageTime = array_sum($times) / count($times);
            $averageTime = date('H:i:s',$averageTime);
        }
        return $averageTime;
    }
}
