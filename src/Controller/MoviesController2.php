<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoviesController2 extends AbstractController
{
    /**
     * @Route("/movies/{name}", name="movies", defaults={"name"=null}, methods={"GET", "HEAD"})
     */
    /*public function index(?string $name): Response
    {
        return $this->render('movies/index.html.twig', [
            'controller_name' => 'MoviesController',
        ]);
    }*/

    /**
     * @Route("/movies/{name}", name="movies", defaults={"name"=null}, methods={"GET", "HEAD"})
     */
    /*public function index(?string $name): Response
    {
        return $this->render('index.html.twig', [
            'title' => $name
        ]);
    }*/

    /**
     * @Route("/movies/{name}", name="movies", defaults={"name"=null}, methods={"GET", "HEAD"})
     */

    //Method 1 for getting data from database
    /*public function index(MovieRepository $movieRepository): Response
    {
        $movies = $movieRepository->findAll();

        dd($movies);

        return $this->render('index.html.twig');
    }*/

    /**
     * @Route("/movies/{name}", name="movies", defaults={"name"=null}, methods={"GET", "HEAD"})
     */

    //Method 2 for getting data from database
    /*public function index(EntityManagerInterface $em): Response
    {
        $repository = $em->getRepository(Movie::class);
        $movies = $repository->findAll();

        dd($movies);

        return $this->render('index.html.twig');
    }*/

    //Preferred method
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/movies/{name}", name="movies", defaults={"name"=null}, methods={"GET", "HEAD"})
     */
    public function index(): Response
    {
        //findAll() - SELECT * FROM movies;
        //find() - SELECT * FROM movies WHERE id = 5;
        //findBy() - SELECT * FROM movies ORDER BY id DESC; ([], ['id' => 'DESC']);
        //findOneBy() - SELECT * FROM movies WHERE id = 11 AND title = 'The Dark Knight' ORDER BY id DESC;
        //count - SELECT COUNT from movies WHERE id = 1; ('id' => 5)
        //getClassName - returns entity class name

        $repository = $this->em->getRepository(Movie::class);
        $movies = $repository->findAll();

        //dd($movies);

        return $this->render('movies/index.html.twig', [
            'movies' => $movies
        ]);
    }

    
}
