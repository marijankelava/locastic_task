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
use App\Services\TransformerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ResultsController extends AbstractController
{
    private RaceRepository $raceRepository;
    private AverageTimeService $averageTimeService;
    private PlacementService $placementService;
    private ResultsRepository $resultsRepository;
    private TransformerService $transformerService;
    private EntityManagerInterface $em;

    public function __construct(
        RaceRepository $raceRepository,
        ResultsRepository $resultsRepository,
        AverageTimeService $averageTimeService,
        PlacementService $placementService,
        TransformerService $transformerService,
        EntityManagerInterface $em
        )
    {
        $this->raceRepository = $raceRepository;
        $this->resultsRepository = $resultsRepository;
        $this->averageTimeService = $averageTimeService;
        $this->placementService = $placementService;
        $this->transformerService = $transformerService;
        $this->em = $em;
    }

    /**
     * @Route("/results", name="app_results")
     */
    public function results(): Response
    {
        $mediumResults = $this->raceRepository->findMedium();
        $longResults = $this->raceRepository->findLong();
        
        $mediumTime = $this->averageTimeService->averageMediumTime($mediumResults);
        $longTime = $this->averageTimeService->averageLongTime($longResults);

        //$transformedMed = $this->transformerService->transformMedium($mediumResults);

        //dd($mediumResults, $longResults);
        //dd($mediumTime, $longTime);
        //dd($transformedMed);
        
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
    public function edit($id, Request $request):Response
    {
        $result = $this->resultsRepository->find($id);
        $form = $this->createForm(ResultsFormType::class, $result);

        $form->handleRequest($request);

        //dd($result);

        if ($form->isSubmitted() && $form->isValid()) {
            $result->setFullName($form->get('fullName')->getData());
            $result->setRaceTime($form->get('raceTime')->getData());
            //dd($result);
            $this->em->flush();

            return $this->redirectToRoute('app_results');
        }

        return $this->render('results/edit.html.twig', [
            'result' => $result,
            'form' => $form->createView()
        ]);
    }
}
