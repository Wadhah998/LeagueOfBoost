<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;                             
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\PriceFilterType;


#[Route('/game')]
class GameController extends AbstractController

{


    #[Route('/', name: 'app_game_index', methods: ['GET', 'POST'])]
    public function index(GameRepository $gameRepository, Request $request): Response
    {
       
        $now = new \DateTime();

        // Define the target datetime
        $date = getdate();
            $date_string = $date['year'] . '-' . $date['mon'] . '-' . $date['mday'] . ' ' . $date['hours'] . ':' . $date['minutes'] . ':' . $date['seconds'];

            $timestamp = strtotime($date_string);
            $target = new \DateTime();
            $target->setTimestamp($timestamp);

        // Calculate the interval between now and the target datetime
        $interval = $now->diff($target);

        // Format the interval as a countdown string
        $countdown = $interval->format('%a days, %h hours, %i minutes, %s seconds');

            $form = $this->createFormBuilder()
            ->add('prixmax', TextType::class, [
                'required' => false,
                'label' => 'prixmax',
                'label_attr' => ['style' => 'color: white']
            ])
            ->add('prixmin', TextType::class, [
                'required' => false,
                'label' => 'prixmin',
                'label_attr' => ['style' => 'color: white']
            ])
            
            ->add('filter', SubmitType::class, [
                'label' => 'Filter'
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $prixmax = $form->get('prixmax')->getData();
            $prixmin = $form->get('prixmin')->getData();
        
            
            $games = $gameRepository->filterByPrice($prixmax,$prixmin);
            
            
            return $this->render('game/index.html.twig', [
                'form' => $form->createView(),
                'games' => $games,
                'countdown' => $countdown,
            ]);
        }

        return $this->render('game/index.html.twig', [
            'form' => $form->createView(),
            'games' => $gameRepository->findAll(),
            'countdown' => $countdown,
            
        ]);
    
    }


    #[Route('details/{id}', name: 'app_game_details', methods: ['GET'])]
    public function details(Game $game): Response
    {
        return $this->render('game/details.html.twig', [
            'game' => $game,
        ]);
    }
    

    


    #[Route('/new', name: 'app_game_new', methods: ['GET', 'POST'])]
    public function new(Request $request, GameRepository $gameRepository): Response
    {
        $game = new Game();
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $gameRepository->save($game, true);

            return $this->redirectToRoute('app_game_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('game/new.html.twig', [
            'game' => $game,
            'form' => $form,
        ]);
    }
  

    #[Route('/{id}', name: 'app_game_show', methods: ['GET'])]
    public function show(Game $game): Response
    {
        return $this->render('game/show.html.twig', [
            'game' => $game,
        ]);
    }


   

    #[Route('/{id}/edit', name: 'app_game_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Game $game, GameRepository $gameRepository): Response
    {
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $gameRepository->save($game, true);

            return $this->redirectToRoute('app_game_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('game/edit.html.twig', [
            'game' => $game,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_game_delete', methods: ['POST'])]
    public function delete(Request $request, Game $game, GameRepository $gameRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$game->getId(), $request->request->get('_token'))) {
            $gameRepository->remove($game, true);
        }

        return $this->redirectToRoute('app_game_index', [], Response::HTTP_SEE_OTHER);
    }
      
   }



   