<?php

namespace App\Controller;

use App\Form\ReservationCType;
use App\Entity\ReservationC;
use App\Repository\ReservationCRepository;
use App\Entity\SessionCoaching;
use App\Form\SessionCoachingType;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\SessionCoachingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/session/coaching')]
class SessionCoachingController extends AbstractController
{
    #[Route('/', name: 'app_session_coaching_index', methods: ['GET'])]
    public function index(SessionCoachingRepository $sessionCoachingRepository, ReservationCRepository $reservationCRepository): Response
    {
        return $this->render('user/coachdashboard.html.twig', [
            'session_coachings' => $sessionCoachingRepository->findAll(),
            'reservation_cs' => $reservationCRepository->findAll(),
        ]);
    }

    #[Route('/new/{id}', name: 'app_session_coaching_new', methods: ['GET', 'POST'])]
    public function new($id,Request $request, SessionCoachingRepository $sessionCoachingRepository): Response
    {
        $sessionCoaching = new SessionCoaching();
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $sessionCoaching->setUser($user) ;
        $form = $this->createForm(SessionCoachingType::class, $sessionCoaching);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sessionCoachingRepository->save($sessionCoaching, true);

            return $this->redirectToRoute('app_session_coaching_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('session_coaching/new.html.twig', [
            'session_coaching' => $sessionCoaching,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_session_coaching_show', methods: ['GET'])]
    public function show(SessionCoaching $sessionCoaching): Response
    {
        return $this->render('session_coaching/show.html.twig', [
            'session_coaching' => $sessionCoaching,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_session_coaching_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SessionCoaching $sessionCoaching, SessionCoachingRepository $sessionCoachingRepository): Response
    {
        $form = $this->createForm(SessionCoachingType::class, $sessionCoaching);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sessionCoachingRepository->save($sessionCoaching, true);

            return $this->redirectToRoute('app_session_coaching_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('session_coaching/edit.html.twig', [
            'session_coaching' => $sessionCoaching,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_session_coaching_delete', methods: ['POST'])]
    public function delete(Request $request, SessionCoaching $sessionCoaching, SessionCoachingRepository $sessionCoachingRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sessionCoaching->getId(), $request->request->get('_token'))) {
            $sessionCoachingRepository->remove($sessionCoaching, true);
        }

        return $this->redirectToRoute('app_session_coaching_index', [], Response::HTTP_SEE_OTHER);
    }
}
