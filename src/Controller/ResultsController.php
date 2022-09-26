<?php

namespace App\Controller;

use App\Services\AverageTimeService;
use App\Entity\Race;
use App\Entity\Results;
use App\Form\RaceFormType;
use App\Form\ResultsFormType;
use App\Repository\RaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResultsController extends AbstractController
{
    private $raceRepository;
    private $averageTimeService;

    public function __construct(RaceRepository $raceRepository, AverageTimeService $averageTimeService)
    {
        $this->raceRepository = $raceRepository;
        $this->averageTimeService = $averageTimeService;
    }

    /**
     * @Route("/results", name="app_results")
     */
    /*public function index(): Response
    {
        return $this->render('results/show.html.twig', [
            'results' => 'Result',
        ]);
    }*/

    /**
     * @Route("/results", name="app_results")
     */
    public function results(): Response
    {
        $mediumResults = $this->raceRepository->findMedium();
        $longResults = $this->raceRepository->findLong();
        //dd($mediumResults, $longResults);

        $mediumTime = $this->averageTimeService->averageMediumTime($mediumResults);
        $longTime = $this->averageTimeService->averageLongTime($longResults);
        dd($mediumTime, $longTime);
        
        return $this->render('results/show.html.twig', [
            'results' => 'Result',
        ]);
    }
}
