<?php

namespace App\Controller;

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

    public function __construct(RaceRepository $raceRepository)
    {
        $this->raceRepository = $raceRepository;
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
        $results = $this->raceRepository->findAll();
        dd($results);
        return $this->render('results/show.html.twig', [
            'results' => 'Result',
        ]);
    }
}
