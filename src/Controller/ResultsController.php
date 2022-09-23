<?php

namespace App\Controller;

use App\Entity\Race;
use App\Entity\Results;
use App\Form\RaceFormType;
use App\Form\ResultsFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResultsController extends AbstractController
{
    /**
     * @Route("/results", name="app_results")
     */
    public function index(): Response
    {
        return $this->render('results/show.html.twig', [
            'results' => 'Result',
        ]);
    }

    /**
     * @Route("/results/create", name="app_create")
     */
    /*public function create(): Response
    {
        $race = new Race();
        $form = $this->createForm(RaceFormType::class, $race);

        return $this->render('results/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }*/
}
