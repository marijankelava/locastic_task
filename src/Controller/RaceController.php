<?php

namespace App\Controller;

use App\Entity\Results;
use App\Entity\Race;
use App\Form\RaceFormType;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\CsvService;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RaceController extends AbstractController
{

    private $em;
    private $csvService;

    public function __construct(EntityManagerInterface $em, CsvService $csvService) 
    {
        $this->em = $em;
        $this->csvService = $csvService;
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
                
                $raceData = $this->csvService->parseCsv($attachment);
                dd($raceData);
            $this->em->persist($newRace);
            $this->em->flush();

            foreach($raceData as $race){
                $race->setRace($newRace);
                $this->em->persist($race);
                $this->em->flush();
            }

            return $this->redirectToRoute('app_results');

        }

        return $this->render('results/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
