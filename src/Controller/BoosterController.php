<?php

namespace App\Controller;

use App\Entity\Booster;
use App\Form\BoosterType;
use App\Repository\BoosterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/booster')]
class BoosterController extends AbstractController
{
    #[Route('/', name: 'app_booster_index', methods: ['GET'])]
    public function index(BoosterRepository $boosterRepository): Response
    {
        return $this->render('booster/index.html.twig', [
            'boosters' => $boosterRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_booster_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BoosterRepository $boosterRepository): Response
    {
        $booster = new Booster();
        $form = $this->createForm(BoosterType::class, $booster);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $boosterRepository->save($booster, true);

            return $this->redirectToRoute('app_booster_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('booster/new.html.twig', [
            'booster' => $booster,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_booster_show', methods: ['GET'])]
    public function show(Booster $booster): Response
    {
        return $this->render('booster/show.html.twig', [
            'booster' => $booster,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_booster_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Booster $booster, BoosterRepository $boosterRepository): Response
    {
        $form = $this->createForm(BoosterType::class, $booster);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $boosterRepository->save($booster, true);

            return $this->redirectToRoute('app_booster_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('booster/edit.html.twig', [
            'booster' => $booster,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_booster_delete', methods: ['POST'])]
    public function delete(Request $request, Booster $booster, BoosterRepository $boosterRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$booster->getId(), $request->request->get('_token'))) {
            $boosterRepository->remove($booster, true);
        }

        return $this->redirectToRoute('app_booster_index', [], Response::HTTP_SEE_OTHER);
    }
}
