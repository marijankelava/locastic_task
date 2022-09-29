<?php

namespace App\Controller;

use App\Form\ResultsFormType;
use App\Repository\RaceRepository;
use App\Repository\ResultsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ResultsController extends AbstractController
{
    private RaceRepository $raceRepository;
    private ResultsRepository $resultsRepository;
    private EntityManagerInterface $em;

    public function __construct(
        RaceRepository $raceRepository,
        ResultsRepository $resultsRepository,
        EntityManagerInterface $em
        )
    {
        $this->raceRepository = $raceRepository;
        $this->resultsRepository = $resultsRepository;
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

        if ($form->isSubmitted() && $form->isValid()) {
            $result->setFullName($form->get('fullName')->getData());
            $result->setRaceTime($form->get('raceTime')->getData());
            
            $this->em->persist($result);
            $this->em->flush();

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
