<?php

namespace App\Controller;

use App\Services\TimeService;
use App\Form\ResultsFormType;
use App\Repository\ResultsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ResultsController extends AbstractController
{
    private ResultsRepository $resultsRepository;
    private TimeService $timeService;
    private EntityManagerInterface $em;

    public function __construct(
        ResultsRepository $resultsRepository,
        TimeService $timeService,
        EntityManagerInterface $em
        )
    {
        $this->resultsRepository = $resultsRepository;
        $this->timeService = $timeService;
        $this->em = $em;
    }

    /**
     * @Route("/results", name="app_results")
     */
    public function results(): Response
    {
        $mediumResults = $this->resultsRepository->getResults('medium');
        $longResults = $this->resultsRepository->getResults('long');

        $averageMediumTime = $this->timeService->averageTime($mediumResults);
        $averageLongTime = $this->timeService->averageTime($longResults);

        return $this->render('results/show.html.twig', [
            'mediumResults' => $mediumResults,
            'longResults' => $longResults,
            'averageMediumTime' => $averageMediumTime,
            'averageLongTime' => $averageLongTime
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

        if ($form->isSubmitted() && $form->isValid()) {
            $result->setFullName($form->get('fullName')->getData());
            $result->setRaceTime($form->get('raceTime')->getData());
            
            $this->resultsRepository->add($result);

            $results = $this->resultsRepository->getResults($result->getDistance());
            
            $i = 1;
            foreach ($results as $result) {
                $result->setPlacement($i);
                $this->em->flush();
                $i++;
            }
            return $this->redirectToRoute('app_results');
        }

        return $this->render('results/edit.html.twig', [
            'result' => $result,
            'form' => $form->createView()
        ]);
    }
}
