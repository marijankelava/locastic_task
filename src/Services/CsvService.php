<?php

namespace App\Services;

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
    public function parseCsv($attachment)
    {
        $open = fopen($attachment, "r");
        $data = fgetcsv($open, 1000, ",");
        while (($data = fgetcsv($open, 1000, ",")) !== FALSE) 
            { 
            //dd($data);      
            //$array[] = $data;
            
            $results = new Results();
            $results->setFullName($data[0]);
            $results->setDistance($data[1]);
            $results->setRaceTime($data[2]);
            $array[] = $results;
            }
            
        fclose($open);
        //dd($array);
        return $array;
    }        
}