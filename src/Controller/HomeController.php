<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Repository\ActualiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index( ActualiteRepository $actualiteRepository): Response
    {
        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
            'actualites' => $actualiteRepository->findAll(),

        ]);
    }
    #[Route('/', name: 'app_actualite_index', methods: ['GET'])]
    public function actualite(ActualiteRepository $actualiteRepository ): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        ;       $entityManager->flush();

        return $this->render('home/home.html.twig', [
            'actualites' => $entityManager->getRepository(Actualite::class)->findActualitesOrderByLikes(),

        ]);
    }
}
