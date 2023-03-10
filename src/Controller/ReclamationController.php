<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Entity\Message;
use App\Form\ReclamationFilterType;
use App\Form\ReclamationType;
use App\Form\MessageType;
use App\Repository\ReclamationRepository;
use App\Repository\MessageRepository;
use App\Repository\RatingRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Rating;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

#[Route('/reclamation')]
class ReclamationController extends AbstractController
{
    #[Route('/a', name: 'app_reclamation_index_all', methods: ['GET','POST'])]
    public function index2(Request $request,ReclamationRepository $reclamationRepository): Response
    {
        $reclamation = new Reclamation();

        $form_f = $this->createForm(ReclamationFilterType::class, $reclamation);
        $form_f->handleRequest($request);

        if ($form_f->isSubmitted() && $form_f->isValid()) {
            $theme = $form_f->get('theme')->getData();
            $etat = $form_f->get('etat')->getData();


            return $this->render('reclamation/index2.html.twig', [
                'ReclamationFilterType' => $form_f->createView(),
                'reclamations' => $reclamationRepository->filterBy($theme,$etat),
            ]);
        }


        return $this->render('reclamation/index2.html.twig', [
            'reclamations' => $reclamationRepository->findAll(),
            'ReclamationFilterType' => $form_f->createView(),
        ]);
    }


    #[Route('/', name: 'app_reclamation_index', methods: ['GET'])]
    public function index(Request $request,ReclamationRepository $reclamationRepository,
                          EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $reclamation = new Reclamation();
        $reclamation->setUser($user);
        return $this->render('reclamation/index.html.twig', [
                'reclamations' => $reclamationRepository->findBy(['user' => $user]),
        ]);

    }

    #[Route('/new', name: 'app_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReclamationRepository $reclamationRepository): Response
    {
        $user = $this->getUser();
        $reclamation = new Reclamation();
        $reclamation->setUser($user);
        $reclamation->setDate(new \DateTime('now'));
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationRepository->save($reclamation, true);

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);


        }
        return $this->renderForm('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reclamation_show', methods: ['GET', 'POST'])]
    public function show(Request $request, Reclamation $reclamation, MessageRepository $messageRepository): Response
    {
        // Retrieve the current user and create a new message object
        $user1 = $this->getUser();
        $message = new Message();
        $message->setUser($user1);
        $message->setReclamation($reclamation);
        $message->setDate(new \DateTime('now'));

        // Create the message and rating forms
        $messageForm = $this->createForm(MessageType::class, $message);
        $form = $this->createFormBuilder()
            ->add('value', ChoiceType::class, [
                'label' => 'Score:',
                'choices' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                ],
                'expanded' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Rate',
                'attr' => ['class' => 'btn btn-primary'],
            ])
            ->getForm();

        // Check if the rating form has been submitted and is valid
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $rating = new Rating();
            $rating->setReclamation($reclamation);
            $rating->setValue($data['value']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rating);
            $entityManager->flush();
            $this->addFlash('success', 'Your rating has been submitted.');
            return $this->redirectToRoute('app_reclamation_show', ['id' => $reclamation->getId()]);
        }

        // Retrieve all the ratings associated with the reclamation
        $ratings = $reclamation->getRatings();

        // Set $hasRating to true if there are any ratings, false otherwise
        $hasRating = (count($ratings) > 0);

        // Render the view and pass the necessary variables
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
            'messageForm' => $messageForm->createView(),
            'form' => $form->createView(),
            'hasRating' => $hasRating,
        ]);
    }


    #[Route('/a/{id}', name: 'app_reclamation_show_a', methods: ['GET', 'POST'])]
    public function show_a(Request $request, Reclamation $reclamation,ReclamationRepository $reclamationRepository,MessageRepository $messageRepository): Response
    {
        $user = $this->getUser();
        $message = new Message();
        $message->setUser($user);
        $message->setReclamation($reclamation);
        $message->setDate(new \DateTime('now'));
        $messageForm = $this->createForm(MessageType::class, $message);
        $messageForm->handleRequest($request);

        if ($messageForm->isSubmitted() && $messageForm->isValid()) {
            $messageRepository->save($message, true);
            $this->addFlash('success', 'Your message has been posted.');


            return $this->redirectToRoute('app_reclamation_show_a', ['id' => $reclamation->getId()]);

        }


        return $this->render('reclamation/show_a.html.twig', [
            'reclamation' => $reclamation,
            'messageForm' => $messageForm->createView(),
            'ratings' => $reclamation->getRatings(),
        ]);
    }



    #[Route('/{id}/edit', name: 'app_reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamationRepository->save($reclamation, true);

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }
    #[Route('/{id}/edita', name: 'app_reclamation_edit_a', methods: ['GET', 'POST'])]
    public function edita(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        $forma = $this->createForm(ReclamationType::class, $reclamation);
        $forma->handleRequest($request);

        if ($forma->isSubmitted() && $forma->isValid()) {
            $reclamationRepository->save($reclamation, true);

            return $this->redirectToRoute('app_reclamation_index_all', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/edita.html.twig', [
            'reclamation' => $reclamation,
            'forma' => $forma,
        ]);
    }

    #[Route('/{id}/d', name: 'app_reclamation_delete', methods: ['GET', 'POST'])]
    public function delete(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getId(), $request->request->get('_token'))) {
            $reclamationRepository->remove($reclamation, true);
        }

        return $this->redirectToRoute('app_reclamation_new', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/del_admin/{id}', name: 'app_reclamation_delete2', methods: ['GET', 'POST'])]
    public function delete2(Request $request, Reclamation $reclamation, ReclamationRepository $reclamationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete2'.$reclamation->getId(), $request->request->get('_token'))) {
            $reclamationRepository->remove($reclamation, true);
        }

        return $this->redirectToRoute('app_reclamation_index_all', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/edit_etat', name: 'app_reclamation_edit_etat', methods: ['GET', 'POST'])]
    public function editEtat(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager ): Response
    {
        $form = $this->createFormBuilder($reclamation)
            ->add('etat', ChoiceType::class, [
                'choices' => [
                    'On hold' => false,
                    'Saved successfully' => true,
                ],
                'expanded' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Update',
                'attr' => ['class' => 'btn btn-primary'],
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();



            return $this->redirectToRoute('app_reclamation_index_all');
        }

        return $this->render('reclamation/edit_etat.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);


    }















}
