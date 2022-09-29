<?php

namespace App\Services;

final class EditPlacementService
{
     public function editPlacementMedium($medium)
    {
        dd(trim($medium[0]['raceTime']));
            array_multisort(array_map('strtotime',array_column($medium, $medium[0]['raceTime'])),
                SORT_ASC, 
                $medium);
            
            //dd($medium);
            return $medium;
    }

    public function editPlacementLong($long)
    { 
            array_multisort(array_map('strtotime',array_column($long, 2)),
                SORT_ASC, 
                $long);
            
            //dd($longResults);
            return $long;
    }   
}