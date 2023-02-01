<?php

namespace App\Controller;

use App\Entity\Forum;
use App\Repository\ForumRepository;
use App\Repository\WorkshopReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_STUDENT')]
class StudentController extends AbstractController
{
    #[Route('/mon-profile', name: 'student_profile')]
    public function index(ForumRepository $forumRepository, WorkshopReservationRepository $workshopReservationRepository): Response
    {
        $forum = $forumRepository->findLastForum();

        return $this->render('pages/student_profile.html.twig', [
            'reservations' => $workshopReservationRepository->findByForumAndStudent($forum, $this->getUser()->getStudent())
        ]);
    }
}