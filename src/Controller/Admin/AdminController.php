<?php

namespace App\Controller\Admin;

use App\Repository\ForumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'admin', methods: ['GET'])]
    public function admin(): Response
    {

        return $this->render('pages/admin/index.html.twig', [

        ]);
    }
}
