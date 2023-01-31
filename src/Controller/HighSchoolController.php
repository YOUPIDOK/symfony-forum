<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_SCHOOL')]
class HighSchoolController extends AbstractController
{
    #[Route('/mon-lycée', name: 'high_school_profile')]
    public function index(): Response
    {
        return $this->render('pages/high_school_profile.html.twig', []);
    }
}