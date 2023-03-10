<?php

namespace App\Controller;

use App\Entity\SessionCoaching;
use App\Form\SessionCoachingType;
use App\Repository\SessionCoachingRepository;
use App\Entity\ReservationC;
use App\Form\ReservationCType;
use App\Repository\ReservationCRepository;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reservation/c')]
class ReservationCController extends AbstractController
{
    #[Route('/', name: 'app_resercation_c_index', methods: ['GET'])]
    public function index(SessionCoachingRepository $sessionCoachingRepository, ReservationCRepository $reservationCRepository): Response
    {
        return $this->render('user/coachdashboard.html.twig', [
            'session_coachings' => $sessionCoachingRepository->findAll(),
            'reservation_cs' => $reservationCRepository->findAll(),
        ]);
    }
    #[Route('/new/{id}', name: 'app_reservation_c_new', methods: ['GET', 'POST'])]
    public function new($id,Request $request, ReservationCRepository $reservationCRepository): Response
    {
        $reservationC = new ReservationC();
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $reservationC->setUser($user) ;
        $form = $this->createForm(ReservationCType::class, $reservationC);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $coach = $reservationC->getUser();
            $prix = $coach->getPrix() * $reservationC->getNbrHeures();
            $reservationC->setPrix($prix);
            $reservationCRepository->save($reservationC, true);

            return $this->redirectToRoute('app_user_listecoach', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation_c/new.html.twig', [
            'reservation_c' => $reservationC,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_c_show', methods: ['GET'])]
    public function show(ReservationC $reservationC): Response
    {
        return $this->render('reservation_c/show.html.twig', [
            'reservation_c' => $reservationC,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reservation_c_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ReservationC $reservationC, ReservationCRepository $reservationCRepository): Response
    {
        $form = $this->createForm(ReservationCType::class, $reservationC);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservationCRepository->save($reservationC, true);

            return $this->redirectToRoute('app_resercation_c_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation_c/edit.html.twig', [
            'reservation_c' => $reservationC,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_c_delete', methods: ['POST'])]
    public function delete(Request $request, ReservationC $reservationC, ReservationCRepository $reservationCRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservationC->getId(), $request->request->get('_token'))) {
            $reservationCRepository->remove($reservationC, true);
        }

        return $this->redirectToRoute('app_resercation_c_index', [], Response::HTTP_SEE_OTHER);
    }

}
