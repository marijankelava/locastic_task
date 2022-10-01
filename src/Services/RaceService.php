<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Race;
use App\Entity\Results;

final class RaceService
{
    private $em;

    public function __construct(
        EntityManagerInterface $em
        ) 
    {
        $this->em = $em;
    }
    public function saveRaceResults(Race $race, array $raceData)
    {
        //dd($raceData);
        foreach ($raceData as $data) {
            if ($data['distance'] == 'medium') {
                $mediumRaceResults[] = $data;
            }else {
                $longRaceResults[] = $data;
            }
        }

        $mediumRaceResults = $this->sortRaceResultsByTime($mediumRaceResults);
        $longRaceResults = $this->sortRaceResultsByTime($longRaceResults);
        
        $this->em->persist($race);
        $this->em->flush();

        $i = 1;
        foreach($mediumRaceResults as $final){
            $result = new Results();
            $result->setRace($race);
            $result->setFullName($final['fullName']);
            $result->setDistance($final['distance']);
            $result->setRaceTime($final['raceTime']);
            $result->setPlacement($i);
            $this->em->persist($result);
            $this->em->flush();
            $i++;
        }

        $i = 1;
        foreach($longRaceResults as $final){
            $result = new Results();
            $result->setRace($race);
            $result->setFullName($final['fullName']);
            $result->setDistance($final['distance']);
            $result->setRaceTime($final['raceTime']);
            $result->setPlacement($i);
            $this->em->persist($result);
            $this->em->flush();
            $i++;
        }
    }

    public function sortRaceResultsByTime(array $results) : array
    {
        usort($results, function ($item1, $item2) {
            return $item1['raceTime'] <=> $item2['raceTime'];
        });

        return $results;
    }
}