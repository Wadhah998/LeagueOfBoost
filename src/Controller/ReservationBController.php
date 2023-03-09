<?php
namespace App\Controller;
use App\Entity\ReservationB;
use App\Form\ReservationBType;
use App\Repository\ReservationBRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reservation/b')]
class ReservationBController extends AbstractController
{
    #[Route('/', name: 'app_reservation_b_index', methods: ['GET'])]
    public function index(ReservationBRepository $reservationBRepository): Response
    {
        return $this->render('reservation_b/index.html.twig', [
            'reservation_bs' => $reservationBRepository->findAll(),
        ]);
    }
    #[Route('/new', name: 'app_reservation_b_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReservationBRepository $reservationBRepository): Response
    {
        $reservationB = new ReservationB();
       //$form = $this->createForm(ReservationBType::class,, ['booster_id' => $boosterId]);

       $form = $this->createForm(ReservationBType::class, $reservationB);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservationBRepository->save($reservationB, true);

            return $this->redirectToRoute('app_reservation_b_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation_b/new.html.twig', [
            'reservation_b' => $reservationB,
            'form' => $form,
        ]);
    }
    #[Route('/{id}', name: 'app_reservation_b_show', methods: ['GET'])]
    public function show(ReservationB $reservationB): Response
    {
        return $this->render('reservation_b/show.html.twig', [
            'reservation_b' => $reservationB,
        ]);
    }
    #[Route('/{id}/edit', name: 'app_reservation_b_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ReservationB $reservationB, ReservationBRepository $reservationBRepository): Response
    {
        $form = $this->createForm(ReservationBType::class, $reservationB);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservationBRepository->save($reservationB, true);

            return $this->redirectToRoute('app_reservation_b_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservation_b/edit.html.twig', [
            'reservation_b' => $reservationB,
            'form' => $form,
        ]);
    }
#[Route('/{id}', name: 'app_reservation_b_delete', methods: ['POST'])]
    public function delete(Request $request, ReservationB $reservationB, ReservationBRepository $reservationBRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservationB->getId(), $request->request->get('_token'))) {
            $reservationBRepository->remove($reservationB, true);
        }
return $this->redirectToRoute('app_reservation_b_index', [], Response::HTTP_SEE_OTHER);
    }
}