<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\BoosterType;
use App\Form\CoachType;
use App\Form\RegistrationFormType;
use App\Form\UserType;
use App\Repository\CoachRepository;
use App\Repository\ReservationBoosterRepository;
use App\Repository\ReservationCRepository;
use App\Repository\SessionBoostingRepository;
use App\Repository\SessionCoachingRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{

    #[Route('/coach', name: 'app_user_listecoach', methods: ['GET','POST'])]
    public function listeCoach(Request $request,UserRepository $userRepository): Response
    {
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
            ->add('Rang', ChoiceType::class,[
                'choices' => [
                    'Aucun filtre' => null,
                    'Master' => 'Master',
                    'Grandmaster' => 'Grandmaster',
                    'Challenger' => 'Challenger',],
                'label_attr' => ['style' => 'color: white']
            ])
            ->add('Voie', ChoiceType::class,[
                'choices' => [
                    'Aucun filtre' => null,
                    'Toplaner' => 'Toplaner',
                    'Jungler' => 'Jungler',
                    'Midlaner' => 'Midlaner',
                    'Support' => 'Support',
                    'ADCarry' => 'ADCarry',],
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
            $rang = $form->get('Rang')->getData();
            $voie = $form->get('Voie')->getData();

            $users = $userRepository->filterByPrice($prixmax,$rang,$voie,$prixmin);
            return $this->render('user/listecoach.html.twig', [
                'form' => $form->createView(),
                'users' => $users,
            ]);
        }
        return $this->render('user/listecoach.html.twig', [
            'form' => $form->createView(),
            'users' => $userRepository->findAll(),
        ]) ;
    }


    #[Route('/sessionC', name: 'app_user_listesession', methods: ['GET','POST'])]
    public function listeSession(Request $request, UserRepository $userRepository, SessionCoachingRepository $sessionCoachingRepository): Response
    {
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

            $session_coachings = $sessionCoachingRepository->findAll($prixmax, $prixmin);
        } else {
            $session_coachings = $sessionCoachingRepository->findAll();
        }

        return $this->render('user/listesession.html.twig', [
            'form' => $form->createView(),
            'session_coachings' => $session_coachings,
        ]);
    }


    #[Route('/coach/dashboard/{id}', name: 'app_user_show_dashboardC', methods: ['GET'])]
    public function showDashboardC(User $user,SessionCoachingRepository $sessionCoachingRepository,ReservationCRepository $reservationCRepository): Response
    {
        return $this->render('user/coachdashboard.html.twig', [
            'user' => $user,
            'session_coachings' => $sessionCoachingRepository->findAll(),
            'reservation_cs' => $reservationCRepository->findALL(),
        ]);
    }


    #[Route('/boost', name: 'app_user_listebooster', methods: ['GET','POST'])]
    public function listebooster(Request $request,UserRepository $userRepository): Response
    {
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
            ->add('Rang', ChoiceType::class,[
                'choices' => [
                    'Aucun filtre' => null,
                    'Master' => 'Master',
                    'Grandmaster' => 'Grandmaster',
                    'Challenger' => 'Challenger',],
                'label_attr' => ['style' => 'color: white']
            ])
            ->add('Voie', ChoiceType::class,[
                'choices' => [
                    'Aucun filtre' => null,
                    'Toplaner' => 'Toplaner',
                    'Jungler' => 'Jungler',
                    'Midlaner' => 'Midlaner',
                    'Support' => 'Support',
                    'ADCarry' => 'ADCarry',],
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
            $rang = $form->get('Rang')->getData();
            $voie = $form->get('Voie')->getData();

            $users = $userRepository->filterByPrice($prixmax,$rang,$voie,$prixmin);
            return $this->render('user/listebooster.html.twig', [
                'form' => $form->createView(),
                'users' => $users,
            ]);
        }
        return $this->render('user/listebooster.html.twig', [
            'form' => $form->createView(),
            'users' => $userRepository->findAll(),
        ]);

    }
    #[Route('/', name: 'app_user_index', methods: ['GET','POST'])]
    public function listeUsers(Request $request,UserRepository $userRepository): Response

    {
        $form = $this->createFormBuilder()

            ->add('role', ChoiceType::class,[
                'choices' => [
                    'Aucun filtre' => null,
                    'Coach' => '["ROLE_CHOACH"]',
                    'Booster' => '["ROLE_BOOSTER"]',
                    'User' => '["ROLE_USER"]',],
                'label_attr' => ['style' => 'color: white']
            ])

            ->add('filter', SubmitType::class, [
                'label' => 'Filter'
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $role = $form->get('role')->getData();


            $users = $userRepository->filterByRole($role);
            return $this->render('user/index.html.twig', [
                'form' => $form->createView(),
                'users' => $users,
            ]);
        }
        return $this->render('user/index.html.twig', [
            'form' => $form->createView(),
            'users' => $userRepository->findAll(),
        ]);

    }

    #[Route('/Json', name: 'app_user_indexJson', methods: ['GET'])]
    public function indexJson(UserRepository $userRepository): JsonResponse
    {
        $users = $userRepository->findAll();

        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'id' => $user->getId(),
                'firstName' => $user->getFirstname(),
                'lastName' => $user->getLastname(),
                'email' => $user->getEmail(),
                'username' => $user->getUsername(),

            ];
        }

        return new JsonResponse($data);
    }
    #[Route('/demandeCoach', name: 'app_user_coachDemande', methods: ['GET'])]
    public function demandeCoach(UserRepository $userRepository): Response
    {
        return $this->render('user/demandeCoach.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/demandeCoachJson', name: 'app_user_coachDemandeJson', methods: ['GET'])]
    public function demandeCoachJson(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        $data = [];
        foreach ($users as $user) {
            if ($user->getVoie() != null && $user->getRoles() == ['ROLE_USER'] && $user->isDisponibility() == null && $user->getUsername() != "admin") {
                $data[] = [
                    'id' => $user->getId(),
                    'firstName' => $user->getFirstname(),
                    'lastName' => $user->getLastname(),
                    'email' => $user->getEmail(),
                    'username' => $user->getUsername(),
                    'solde' => $user->getSolde(),
                    'prix' => $user->getPrix(),
                    'lienOpgg' => $user->getLienOpgg(),
                    'voie' => $user->getVoie(),
                ];
            }
        }

        return $this->json($data);
    }
    #[Route('/demandeBooster', name: 'app_user_BoosterDemande', methods: ['GET'])]
    public function demandeBooster(UserRepository $userRepository): Response
    {
        return $this->render('user/demandeBooster.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }
    #[Route('/demandeBoosterJson', name: 'app_user_demandeBosterJson', methods: ['GET'])]
    public function demandeBosterJson(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();

        $data = [];
        foreach ($users as $user) {
            if ($user->getVoie() != null && $user->getRoles() == ['ROLE_USER'] && $user->isDisponibility() != null && $user->getUsername() != "admin") {
                $data[] = [
                    'id' => $user->getId(),
                    'firstName' => $user->getFirstname(),
                    'lastName' => $user->getLastname(),
                    'email' => $user->getEmail(),
                    'username' => $user->getUsername(),
                    'solde' => $user->getSolde(),
                    'prix' => $user->getPrix(),
                    'lienOpgg' => $user->getLienOpgg(),
                    'voie' => $user->getVoie(),
                ];
            }
        }

        return $this->json($data);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }
    #[Route('/Json/{id}', name: 'app_user_show-json', methods: ['GET'])]
    public function showJson(User $user): JsonResponse
    {
        $responseData = [
            'id' => $user->getId(),
            'firstname' => $user->getFirstname(),
            'lastname' => $user->getLastname(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),

        ];

        return new JsonResponse($responseData);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form
        ]);
    }
    #[Route('/{id}/editCoach', name: 'app_user_editcoach', methods: ['GET', 'POST'])]
    public function editCoach(Request $request, User $user, UserRepository  $coachRepository ): Response
    {
        $form = $this->createForm(CoachType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $coachRepository->save($user, true);

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/beCoach.html.twig', [
            'user' => $user,
            'Coachform' => $form
        ]);
    }
    #[Route('/{id}/editBooster', name: 'app_user_editBooster', methods: ['GET', 'POST'])]
    public function editBooster(Request $request, User $user, UserRepository  $boosterRepository ): Response
    {
        $form = $this->createForm(BoosterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $boosterRepository->save($user, true);

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/beBooster.html.twig', [
            'user' => $user,
            'BoosterForm' => $form
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/delete/{id}', name: 'app_user_delete-json', methods: ['POST'])]
    public function deleteJson(Request $request, User $user, UserRepository $userRepository): JsonResponse
    {
        $userRepository->remove($user, true);
        return new JsonResponse("User deleted successfully", 200);
    }

    #[Route("/edit-role/{id}", name:'edit_user_role')]

    public function editUserRole($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }

        $user->setRoles(['ROLE_CHOACH']);

        $entityManager->flush();

        return $this->redirectToRoute('app_user_coachDemande', [], Response::HTTP_SEE_OTHER);
    }
    #[Route("/edit-role-booster/{id}", name:'edit_user_role_booster')]
    public function editUserRoleBooster($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for id '.$id
            );
        }

        $user->setRoles(['ROLE_BOOSTER']);

        $entityManager->flush();

        return $this->redirectToRoute('app_user_BoosterDemande', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/session', name: 'app_user_listesessionbooster', methods: ['GET','POST'])]
    public function listeSessionBooster(Request $request, UserRepository $userRepository, SessionBoostingRepository $sessionBoostingRepository): Response
    {
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

            $session_boostings = $sessionBoostingRepository->findAll($prixmax, $prixmin);
        } else {
            $session_boostings = $sessionBoostingRepository->findAll();
        }

        return $this->render('user/listesessionbooster.html.twig', [
            'form' => $form->createView(),
            'session_boostings' => $session_boostings,
        ]);
    }
    #[Route('/booster/dashboard/{id}', name: 'app_user_show_dashboard', methods: ['GET'])]
        public function showDashboard(User $user,SessionBoostingRepository $sessionBoostingRepository,ReservationBoosterRepository $reservationBoosterRepository): Response
{
    return $this->render('user/boosterdashboard.html.twig', [
        'user' => $user,
        'session_boostings' => $sessionBoostingRepository->findAll(),
        'reservation_boosters' => $reservationBoosterRepository->findAll(),
    ]);
}


}
