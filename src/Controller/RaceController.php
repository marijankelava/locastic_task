<?php

namespace App\Controller;

use App\Entity\Race;
use App\Form\RaceFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RaceController extends AbstractController
{

    private $em;
    private $movieRepository;
    public function __construct(EntityManagerInterface $em) 
    {
        $this->em = $em;
    }

    /**
     * @Route("/resulta", name="app_results")
     */
    /*public function showResults(): Response
    {
        return $this->render('race/index.html.twig', [
            'controller_name' => 'RaceController',
        ]);
    }*/

    /**
     * @Route("/race", name="app_race")
     */
    public function index(): Response
    {
        return $this->render('race/index.html.twig', [
            'controller_name' => 'RaceController',
        ]);
    }

    /**
     * @Route("/race/create", name="app_race_create")
     */
    public function create(Request $request): Response
    {
        $race = new Race();
        $form = $this->createForm(RaceFormType::class, $race);
        $newRace = [];
        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $newRace = $form->getData();
                $attachment = $form->get('attachment')->getData();
                //var_dump($newRace, $attachment);
            }/*else {
                return $this->redirectToRoute('app_race');
            }*/

            $this->em->persist($newRace);
            $this->em->flush();

        return $this->render('results/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
