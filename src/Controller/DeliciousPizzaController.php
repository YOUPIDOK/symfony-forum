<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeliciousPizzaController extends AbstractController
{
    #[Route('/delicious/pizza', name: 'app_delicious_pizza')]
    public function index(): Response
    {
        return $this->render('delicious_pizza/index.html.twig', [
            'controller_name' => 'DeliciousPizzaController',
        ]);
    }
}
