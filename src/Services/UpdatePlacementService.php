<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;

final class UpdatePlacementService
{
    private $em;

    public function __construct(
        EntityManagerInterface $em
        ) 
    {
        $this->em = $em;
    }

    public function updatePlacement($update, $name): int
    {
        usort($update, function ($item1, $item2) {
            return $item1['raceTime'] <=> $item2['raceTime'];
        });
        
        foreach ($update as $value) {
            $placement[] = $value['fullName'];
        }
        //dd($placement);
        $updatedPlacement = (array_search($name, $placement) + 1);
        
        return $updatedPlacement;
    }    
}