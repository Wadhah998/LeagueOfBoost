<?php

namespace App\Controller;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Entity\SessionBoosting;
use App\Form\SessionBoostingType;
use App\Repository\SessionBoostingRepository;
use App\Entity\ReservationBooster;
use App\Form\ReservationBoosterType;
use App\Repository\ReservationBoosterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/session/boosting')]
class SessionBoostingController extends AbstractController
{
    #[Route('/', name: 'app_session_boosting_index', methods: ['GET'])]
    public function index(SessionBoostingRepository $sessionBoostingRepository,ReservationBoosterRepository $reservationBoosterRepository): Response
    {
        return $this->render('user/boosterdashboard.html.twig', [
            'session_boostings' => $sessionBoostingRepository->findAll(),
            'reservation_boosters' => $reservationBoosterRepository->findAll(),
        ]);
    }

    #[Route('/new/{id}', name: 'app_session_boosting_new', methods: ['GET', 'POST'])]
    public function new(Request $request,$id, SessionBoostingRepository $sessionBoostingRepository): Response
    {
        $sessionBoosting = new SessionBoosting();
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $sessionBoosting->setUser($user) ;
        $form = $this->createForm(SessionBoostingType::class, $sessionBoosting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sessionBoostingRepository->save($sessionBoosting, true);

            return $this->redirectToRoute('app_session_boosting_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('session_boosting/new.html.twig', [
            'session_boosting' => $sessionBoosting,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_session_boosting_show', methods: ['GET'])]
    public function show(SessionBoosting $sessionBoosting): Response
    {
        return $this->render('session_boosting/show.html.twig', [
            'session_boosting' => $sessionBoosting,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_session_boosting_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SessionBoosting $sessionBoosting, SessionBoostingRepository $sessionBoostingRepository): Response
    {
        $form = $this->createForm(SessionBoostingType::class, $sessionBoosting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sessionBoostingRepository->save($sessionBoosting, true);

            return $this->redirectToRoute('app_session_boosting_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('session_boosting/edit.html.twig', [
            'session_boosting' => $sessionBoosting,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_session_boosting_delete', methods: ['POST'])]
    public function delete(Request $request, SessionBoosting $sessionBoosting, SessionBoostingRepository $sessionBoostingRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sessionBoosting->getId(), $request->request->get('_token'))) {
            $sessionBoostingRepository->remove($sessionBoosting, true);
        }

        return $this->redirectToRoute('app_session_boosting_index', [], Response::HTTP_SEE_OTHER);
    }
}
