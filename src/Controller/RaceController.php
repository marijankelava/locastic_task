<?php

namespace App\Controller;

use App\Entity\Race;
use App\Form\RaceFormType;
use App\Services\FileService;
use App\Services\RaceService;
use App\Services\SupportedFileTypes;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RaceController extends AbstractController
{

    private $fileService;
    private $raceService;

    public function __construct(
        FileService $fileService,
        RaceService $raceService
        ) 
    {
        $this->fileService = $fileService;
        $this->raceService = $raceService;
    }

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

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $race = $form->getData();
            $file = $form->get('attachment')->getData();

            if (SupportedFileTypes::isSupportedFileType($file->getClientOriginalExtension())  !== true) {
                throw new RuntimeException('Invalid file type');
            }
            
            $raceData = $this->fileService->parseRaceCsvToArray($file);

            // save race data
            $this->raceService->saveRaceResults($race, $raceData);

            return $this->redirectToRoute('app_results');
        }

        return $this->render('results/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
