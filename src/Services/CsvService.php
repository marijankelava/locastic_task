<?php

namespace App\Services;

use App\Entity\Race;
use App\Form\RaceFormType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CsvService
{
    public function parseCsv($attachment): array
    {
        $open = fopen($attachment, "r");
        $data = fgetcsv($open, 1000, ",");
        while (($data = fgetcsv($open, 1000, ",")) !== FALSE) 
            {        
            $array[] = $data; 
            }
  
        fclose($open);
        //dd($array);
        return $array;
    }        
}