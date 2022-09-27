<?php

namespace App\Services;

final class PlacementService
{
    public function placementMedium($mediumResults)
    {
        
            array_multisort(array_map('strtotime',array_column($mediumResults,'raceTime')),
                SORT_ASC, 
                $mediumResults);
            
            //dd($mediumResults);

            return $mediumResults;
    }

    public function placementLong($longResults)
    {
        
            array_multisort(array_map('strtotime',array_column($longResults,'raceTime')),
                SORT_ASC, 
                $longResults);
            
            //dd($longResults);

            return $longResults;
    }
}