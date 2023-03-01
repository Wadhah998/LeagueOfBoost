<?php

namespace App\Controller;

use App\Controller\GameController;
use App\Repository\GameRepository;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_game_admin', methods: ['GET'])]
    public function admin(GameRepository $gameRepository, TeamRepository $teamRepository): Response
    {
        return $this->render('admin/admin.html.twig', [
            'games' => $gameRepository->findAll(),
            'teams' => $teamRepository->findAll(),
        ]);
    }

}
