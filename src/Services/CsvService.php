<?php

namespace App\Services;

use App\Services\PlacementService;
use App\Entity\Results;
use App\Entity\Race;
use App\Form\RaceFormType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CsvService
{
    private $placementService;

    public function __construct(PlacementService $placementService)
    {
        $this->placementService = $placementService;
    }

    public function parseCsv($attachment)
    {
        $open = fopen($attachment, "r");
        $data = fgetcsv($open, 1000, ",");
        $medium = [];
        $long = [];
        while (($data = fgetcsv($open, 1000, ",")) !== FALSE) 
            { 
                //dd($data);
                if (str_replace(' ', '', $data[1]) === 'medium') {
                    $medium[] = $data;
                }else {
                    $long[] = $data;
                }
            }   
            //dd($medium, $long);

            $mediumArray = $this->placementService->placementMedium($medium);
            $longArray = $this->placementService->placementLong($long);

            $i = 1;
            foreach ($mediumArray as $medium) {
                $results = new Results();
                $results->setFullName($medium[0]);
                $results->setDistance($medium[1]);
                $results->setRaceTime($medium[2]);
                $results->setPlacement($i);
                $data[] = $results;
                $i++;
            }

            $i = 1;
            foreach ($longArray as $long) {
                $results = new Results();
                $results->setFullName($long[0]);
                $results->setDistance($long[1]);
                $results->setRaceTime($long[2]);
                $results->setPlacement($i);
                $data[] = $results;
                $i++;
            }
            //dd($data);

        /*while (($data = fgetcsv($open, 1000, ",")) !== FALSE) 
            { 
            $results = new Results();
            $results->setFullName($data[0]);
            $results->setDistance($data[1]);
            $results->setRaceTime($data[2]);
            $array[] = $results;
            }*/
            
        fclose($open);
        
        return $data;
    }        
}