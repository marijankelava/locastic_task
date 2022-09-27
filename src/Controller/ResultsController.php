<?php

namespace App\Controller;

use App\Services\AverageTimeService;
use App\Entity\Race;
use App\Entity\Results;
use App\Form\RaceFormType;
use App\Form\ResultsFormType;
use App\Repository\RaceRepository;
use App\Repository\ResultsRepository;
use App\Services\PlacementService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResultsController extends AbstractController
{
    private $raceRepository;
    private $averageTimeService;
    private $placementService;
    private $resultsRepository;

    public function __construct(RaceRepository $raceRepository, ResultsRepository $resultsRepository, AverageTimeService $averageTimeService, PlacementService $placementService)
    {
        $this->raceRepository = $raceRepository;
        $this->resultsRepository = $resultsRepository;
        $this->averageTimeService = $averageTimeService;
        $this->placementService = $placementService;
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

        //dd($mediumResults);
        //$mediumPlacement = $this->placementService->placementMedium($mediumResults);
        //$longPlacement = $this->placementService->placementLong($longResults);
        
        $mediumTime = $this->averageTimeService->averageMediumTime($mediumResults);
        $longTime = $this->averageTimeService->averageLongTime($longResults);

        //dd($mediumTime, $longTime);
        
        return $this->render('results/show.html.twig', [
            'mediumTime' => $mediumTime,
            'mediumResults' => $mediumResults,
            'longTime' => $longTime,
            'longResults' => $longResults
        ]);
    }

    /**
     * @Route("/results/edit/{id}", name="app_edit")
     */
    public function edit($id):Response
    {
        $result = $this->resultsRepository->find($id);
        $form = $this->createForm(ResultsFormType::class, $result);

        return $this->render('results/edit.html.twig', [
            'result' => $result,
            'form' => $form->createView()
        ]);
    }
}
