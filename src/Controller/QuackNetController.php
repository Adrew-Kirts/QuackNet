<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuackNetController extends AbstractController
{
    #[Route('/quack/net', name: 'app_quack_net')]
    public function index(): Response
    {
        return $this->render('quack_net/index.html.twig', [
            'controller_name' => 'QuackNetController',
        ]);
    }
}


