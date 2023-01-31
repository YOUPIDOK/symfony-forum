<?php

namespace App\Controller;

use App\Controller\Admin\ForumController;
use App\Entity\Workshop;
use App\Repository\ForumRepository;
use App\Repository\JobActivityRepository;
use App\Repository\JobSkillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WorkshopController extends AbstractController
{
    #[Route('/atelier', name: 'workshops')]
    public function workshops(ForumRepository $forumRepository): Response
    {
        $forum = $forumRepository->findLastForum();

        return $this->render('pages/workshops.html.twig', [
            'forum' => $forum
        ]);
    }

    #[Route('/atelier/{id}', name: 'workshop')]
    public function workshop(
        Workshop $workshop,
        JobActivityRepository $jobActivityRepository,
        JobSkillRepository $jobSkillRepository
    ): Response
    {
        return $this->render('pages/workshop.html.twig', [
            'workshop' => $workshop,
            'jobActivities' => $jobActivityRepository->findByWorkshop($workshop),
            'jobSkills' => $jobSkillRepository->findByWorkshop($workshop),
        ]);
    }
}