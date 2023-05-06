<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Entity\ReservationBooster;
use App\Form\ReservationBoosterType;
use App\Repository\ReservationBoosterRepository;
use App\Entity\SessionBoosting;
use App\Form\SessionBoostingType;
use App\Repository\SessionBoostingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reservation/booster')]
class ReservationBoosterController extends AbstractController
{
    #[Route('/', name: 'app_reservation_booster_index', methods: ['GET'])]
    public function index(SessionBoostingRepository $sessionBoostingRepository,ReservationBoosterRepository $reservationBoosterRepository): Response
    {
        return $this->render('user/boosterdashboard.html.twig', [
            'reservation_boosters' => $reservationBoosterRepository->findAll(),
            'session_boostings' => $sessionBoostingRepository->findAll(),
        ]);
    }

    #[Route('/new/{id}', name: 'app_reservation_booster_new', methods: ['GET', 'POST'])]
    public function new(Request $request,$id, ReservationBoosterRepository $reservationBoosterRepository): Response
    {
        $reservationBooster = new ReservationBooster();
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $reservationBooster->setUser($user) ;
        $form = $this->createForm(ReservationBoosterType::class, $reservationBooster);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservationBoosterRepository->save($reservationBooster, true);

            return $this->redirectToRoute('app_user_listebooster', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation_booster/new.html.twig', [
            'reservation_booster' => $reservationBooster,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_booster_show', methods: ['GET'])]
    public function show(ReservationBooster $reservationBooster): Response
    {
        return $this->render('reservation_booster/show.html.twig', [
            'reservation_booster' => $reservationBooster,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reservation_booster_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ReservationBooster $reservationBooster, ReservationBoosterRepository $reservationBoosterRepository): Response
    {
        $form = $this->createForm(ReservationBoosterType::class, $reservationBooster);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservationBoosterRepository->save($reservationBooster, true);

            return $this->redirectToRoute('app_reservation_booster_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation_booster/edit.html.twig', [
            'reservation_booster' => $reservationBooster,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_booster_delete', methods: ['POST'])]
    public function delete(Request $request, ReservationBooster $reservationBooster, ReservationBoosterRepository $reservationBoosterRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservationBooster->getId(), $request->request->get('_token'))) {
            $reservationBoosterRepository->remove($reservationBooster, true);
        }

        return $this->redirectToRoute('app_reservation_booster_index', [], Response::HTTP_SEE_OTHER);
    }
}
