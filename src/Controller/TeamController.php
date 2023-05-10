<?php

namespace App\Controller;

use App\Entity\Team;
use App\Entity\Game;
use App\Form\GameType;
use App\Form\Team1Type;
use App\Repository\GameRepository;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


#[Route('/team')]
class TeamController extends AbstractController
{
    #[Route('/', name: 'app_team_index', methods: ['GET'])]
    public function index(TeamRepository $teamRepository): Response
    {
        return $this->render('team/index.html.twig', [
            'teams' => $teamRepository->findAll(),
        ]);
    }

   
    #[Route('/new', name: 'app_team_new', methods: ['GET', 'POST'])]

    public function new(Request $request, TeamRepository $teamRepository): Response
    {
        $team = new Team();
        $form = $this->createForm(Team1Type::class, $team);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $teamRepository->save($team, true);

            $this->addFlash('success', 'Your success message goes here.');
            
            return $this->redirectToRoute('app_game_index', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->renderForm('team/new.html.twig', [
            'team' => $team,
            'form' => $form,
        ]); 
    }
    
    

    #[Route('/{id}', name: 'app_team_show', methods: ['GET'])]
    public function show(Team $team): Response
    {
        return $this->render('team/show.html.twig', [
            'team' => $team,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_team_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Team $team, TeamRepository $teamRepository): Response
    {
        $form = $this->createForm(Team1Type::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $teamRepository->save($team, true);

            return $this->redirectToRoute('app_team_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('team/edit.html.twig', [
            'team' => $team,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_team_delete', methods: ['POST'])]
    public function delete(Request $request, Team $team, TeamRepository $teamRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$team->getId(), $request->request->get('_token'))) {
            $teamRepository->remove($team, true);
        }

        return $this->redirectToRoute('app_game_admin', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'game_view')]
    public function view(string $id,Game $game, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Retrieve the game by ID from the database
        $game = $entityManager->getRepository(Game::class)->find($id);

        // Render the view with the game information
        return $this->render('game/details.html.twig', [
            'game' => $game,
        ]);
    }
  
}
