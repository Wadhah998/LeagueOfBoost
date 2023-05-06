<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Form\ActualiteType;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\ActualiteRepository;
use App\Repository\CommentaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/home')]
class ActualiteController extends AbstractController
{


    #[Route('/new', name: 'app_actualite_new', methods: ['GET', 'POST'])]
    public function newnew(Request $request, ActualiteRepository $actualiteRepository): Response
    {
        $actualite = new Actualite();
        $form = $this->createForm(ActualiteType::class, $actualite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $actualiteRepository->save($actualite, true);

            return $this->redirectToRoute('app_actualite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('actualite/new.html.twig', [
            'actualite' => $actualite,
            'actualites' => $actualiteRepository->findAll(),
            'form' => $form,
        ]);
    }
    #[Route('/newnew', name: 'app_actualite_newnew', methods: ['GET', 'POST'])]
    public function new(Request $request, ActualiteRepository $actualiteRepository): Response
    {
        $actualite = new Actualite();
        $form = $this->createForm(ActualiteType::class, $actualite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $actualiteRepository->save($actualite, true);

            return $this->redirectToRoute('app_actualite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('actualite/newnew.html.twig', [
            'actualite' => $actualite,
            'actualites' => $actualiteRepository->findAll(),
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_actualite_show', methods: ['GET'])]
    public function show(Actualite $actualite, CommentaireRepository $commentaireRepository, Request $request): Response
    {
        $commentaire = new Commentaire();
        
        // create a Commentaire form
        $form = $this->createForm(CommentaireType::class, $commentaire);
    
        // handle Commentaire form submission
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $commentaireRepository->save($commentaire, true);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentaire);
            $entityManager->flush();
            return $this->redirectToRoute('app_commentaire_index', [], Response::HTTP_SEE_OTHER);
        }
    
        // handle like button click
        if ($request->isMethod('POST') && $request->request->get('like')) {
            $likes = $actualite->getLikes();
            $newLikes = $likes + 1;
            $actualite->setLikes($newLikes);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_actualite_show', [
                'id' => $actualite->getId(),
            ], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('actualite/show.html.twig', [
            'actualite' => $actualite,
            'commentaires' => $commentaireRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }
    
    


    #[Route('/{id}/edit', name: 'app_actualite_edit', methods: ['GET', 'POST'])]
     function edit(Request $request, Actualite $actualite, ActualiteRepository $actualiteRepository): Response
    {
        $form = $this->createForm(ActualiteType::class, $actualite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $actualiteRepository->save($actualite, true);

            return $this->redirectToRoute('app_actualite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('actualite/edit.html.twig', [
            'actualite' => $actualite,
            'form' => $form,
        ]);
    }
    #[Route('/{id}', name: 'app_actualite_delete', methods: ['POST'])]
    function delete(Request $request, Actualite $actualite, ActualiteRepository $actualiteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$actualite->getId(), $request->request->get('_token'))) {
            $actualiteRepository->remove($actualite, true);
        }

        return $this->redirectToRoute('app_actualite_index', [], Response::HTTP_SEE_OTHER);
    }
 /*   #[Route('/liste', name:'app_actualite_liste', methods: ['GET'])]
    public function liste(ActualiteRepository $actualiteRepository): Response
    {
        
        return $this->render('actualite/liste.html.twig', [
            'actualites' => $actualiteRepository->findAll(),
        ]);
    }*/

    #[Route('/admin', name:'app_actualite_admin', methods: ['GET'])]
     function admin(ActualiteRepository $actualiteRepository): Response
    {
        
        return $this->render('actualite/admin.html.twig', [
            'actualites' => $actualites->findAll(),
        ]);
    }
    

}
