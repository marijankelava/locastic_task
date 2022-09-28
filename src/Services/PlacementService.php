<?php

namespace App\Services;

final class PlacementService
{
     public function placementMedium($medium)
    {
            array_multisort(array_map('strtotime',array_column($medium, 2)),
                SORT_ASC, 
                $medium);
            
            //dd($medium);
            return $medium;
    }

    public function placementLong($long)
    { 
            array_multisort(array_map('strtotime',array_column($long, 2)),
                SORT_ASC, 
                $long);
            
            //dd($longResults);
            return $long;
    }   
}