<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TournoisController extends AbstractController
{
    #[Route('/game', name: 'app_tournois')]
    public function index(): Response
    {
        return $this->render('tournois/index.html.twig', [
            'controller_name' => 'TournoisController',
        ]);
    }
}
