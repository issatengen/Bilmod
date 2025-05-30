<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminUsersAuthController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // If the user is already logged in, redirect to the homepage or dashboard
        if ($this->getUser()) {
            return $this->redirectToRoute('app_admin_home'); // Change to your actual homepage route
        }
        // Get the login error if there is one
        // This will display the login form with any error messages
        // The AuthenticationUtils service provides methods to retrieve the last authentication error and the last username entered
        // This is useful for displaying error messages and pre-filling the username field
        // The AuthenticationUtils service is used to handle authentication-related tasks
        // such as retrieving the last authentication error and the last username entered by the user.
        // The login form will be rendered in the 'security/login.html.twig' template
        // The 'last_username' variable will contain the last entered username
        // The 'error' variable will contain any authentication error that occurred during the login attempt
        // If the user is already logged in, redirect to the homepage or dashboard

        // Show login form if not logged in
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
