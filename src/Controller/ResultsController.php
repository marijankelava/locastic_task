<?php

namespace App\Controller;

use App\Services\RaceService;
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
    private RaceService $raceService;
    private EntityManagerInterface $em;

    public function __construct(
        ResultsRepository $resultsRepository,
        RaceService $raceService,
        EntityManagerInterface $em
        )
    {
        $this->resultsRepository = $resultsRepository;
        $this->raceService = $raceService;
        $this->em = $em;
    }

    /**
     * @Route("/results", name="app_results")
     */
    public function results(): Response
    {
        $mediumResults = $this->resultsRepository->getResults('medium');
        $longResults = $this->resultsRepository->getResults('long');
        
        return $this->render('results/show.html.twig', [
            'mediumResults' => $mediumResults,
            'longResults' => $longResults,
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
