<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ClientSideController extends AbstractController
{
    #[Route('/home', name: 'app_client_side')]
    public function index(): Response
    {
        return $this->render('client_side/index.html.twig', [
            'controller_name' => 'ClientSideController',
        ]);
    }
}
