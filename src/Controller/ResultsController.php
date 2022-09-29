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
use App\Services\EditPlacementService;
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
    private EditPlacementService $editPlacementService;
    private EntityManagerInterface $em;

    public function __construct(
        RaceRepository $raceRepository,
        ResultsRepository $resultsRepository,
        AverageTimeService $averageTimeService,
        PlacementService $placementService,
        TransformerService $transformerService,
        EditPlacementService $editPlacementService,
        EntityManagerInterface $em
        )
    {
        $this->raceRepository = $raceRepository;
        $this->resultsRepository = $resultsRepository;
        $this->averageTimeService = $averageTimeService;
        $this->placementService = $placementService;
        $this->transformerService = $transformerService;
        $this->editPlacementService = $editPlacementService;
        $this->em = $em;
    }

    /**
     * @Route("/results", name="app_results")
     */
    public function results(): Response
    {
 
        $results = $this->raceRepository->findAll();

        //dd($results);
        
        return $this->render('results/show.html.twig', [
            'results' => $results
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

            $this->em->persist($result);
            $this->em->flush();

            // get all race results, sort them by time and resave

            return $this->redirectToRoute('app_results');
        }

        return $this->render('results/edit.html.twig', [
            'result' => $result,
            'form' => $form->createView()
        ]);
    }
}
