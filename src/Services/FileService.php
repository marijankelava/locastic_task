<?php

namespace App\Services;

final class FileService
{
    public function parseRaceCsvToArray($attachment)
    {
        $open = fopen($attachment, "r");
        $data = fgetcsv($open, 1000, ",");
        $raceResults = [];
        while (($data = fgetcsv($open, 1000, ",")) !== FALSE) 
            { 
                
                if (strlen($data[0]) === 0 || strlen($data[1]) === 0 || strlen($data[2]) === 0) {
                    throw new \Exception('File is not valid');
                }
                
                $raceResults[] = ['fullName' => trim($data[0]), 'distance' => trim($data[1]), 'raceTime' => trim($data[2])];
            }   
            
        fclose($open);
        
        return $raceResults;
    }        
}