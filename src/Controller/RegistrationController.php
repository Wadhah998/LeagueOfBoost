<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\AppCustomAuthenticator;
use Doctrine\ORM\EntityManagerInterface;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{



    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, AppCustomAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles(['ROLE_USER']);
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    #[Route('/registerJson', name: 'app_registerJson')]



    public function registerJson(UserPasswordHasherInterface $userPasswordHasher,EntityManagerInterface $entityManager,ManagerRegistry $doctrine,Request $request)
    {
        $requestData = $request->getContent();
        parse_str($requestData, $data);

        // Accéder aux données de la requête
        $firstname=$request->query->get('firstname');
        $email=$request->query->get('email');
        $lastname=$request->query->get('lastname');
        $username = $request->query->get('username');
        $plainPassword = $request->query->get('plainPassword');
/*
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return new Response("email invalid.");
        }*/

        $user = new User();

        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setUsername($username);



        $user->setRoles(array("ROLE_USER"));

        $user->setEmail($email);
        $user->setPassword(
            $userPasswordHasher->hashPassword(
                $user,
                $request->query->get('plainPassword')
            )
        );



        try {

            $entityManager->persist($user);
            $entityManager->flush();

            return new JsonResponse("Account is cretaed", 200);
        }catch(\Exception $ex) {
            return new Response("exception".$ex->getMessage());
        }
    }


}


