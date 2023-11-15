<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    //  public function index(): Response
//    public function index(AuthenticationUtils $authenticationUtils): Response
//    {
//        // get the login error if there is one
//        $error = $authenticationUtils->getLastAuthenticationError();
//
//        // last username entered by the user
//        $lastUsername = $authenticationUtils->getLastUsername();
//
//        return $this->render('login/index.html.twig', [
//            'controller_name' => 'LoginController',
//            'last_username' => $lastUsername,
//            'error'         => $error,
//        ]);
//    }

    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username or email entered by the user
        $lastUsernameOrEmail = $authenticationUtils->getLastUsername();

        // Attempt to load the user by duckname or email
//        $user = $userRepository->loadUserByUsernameOrEmail($lastUsernameOrEmail);

        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsernameOrEmail,
            'error' => $error,
        ]);
    }
}
