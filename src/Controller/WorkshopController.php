<?php

namespace App\Controller;

use App\Controller\Admin\ForumController;
use App\Entity\Workshop;
use App\Entity\WorkshopReservation;
use App\Repository\ForumRepository;
use App\Repository\JobActivityRepository;
use App\Repository\JobSkillRepository;
use App\Repository\WorkshopReservationRepository;
use ErrorException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

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
        JobSkillRepository $jobSkillRepository,
        ForumRepository $forumRepository,
        WorkshopReservationRepository $workshopReservationRepository
    ): Response
    {
        $canAddReservation = false;
        if ($this->isGranted('ROLE_STUDENT')) {
            $student = $this->getUser()->getStudent();
            $forum = $forumRepository->findLastForum();

            if (
                $forum->canAddReservation() // Le dernier forum est encore ouvert
                && $forum === $workshop->getForum() // Le workshop fait partis du dernier forum
                && $student->getWorkshopReservations()->count() < 3 // Pas déja 3 réservations
                && $workshopReservationRepository->findOneBy(['student' => $student, 'workshop' => $workshop]) === null // Pas déja inscrit
            ) {
                $canAddReservation = true;
            }
        }

        return $this->render('pages/workshop.html.twig', [
            'canAddReservation' => $canAddReservation,
            'workshop' => $workshop,
            'jobActivities' => $jobActivityRepository->findByWorkshop($workshop),
            'jobSkills' => $jobSkillRepository->findByWorkshop($workshop),
        ]);
    }

    #[IsGranted('ROLE_STUDENT')]
    #[Route('/atelier/{id}/inscription', name: 'workshop_reservation')]
    public function inscription(Workshop $workshop, WorkshopReservationRepository $workshopReservationRepository, ForumRepository $forumRepository): Response
    {
        $student = $this->getUser()->getStudent();
        $forum = $forumRepository->findLastForum();

        if (
            $forum->canAddReservation() // Le dernier forum est encore ouvert
            && $forum === $workshop->getForum() // Le workshop fait partis du dernier forum
            && $student->getWorkshopReservations()->count() < 3 // Pas déja 3 réservations
            && $workshopReservationRepository->findOneBy(['student' => $student, 'workshop' => $workshop]) === null // Pas déja inscrit
        ) {
            $workshopReservation = new WorkshopReservation();
            $workshopReservation->setWorkshop($workshop);
            $workshopReservation->setStudent($student);

            $workshopReservationRepository->save($workshopReservation, true);
        } else {
          throw new ErrorException("Impossible de s'inscire");
        }

        return $this->redirectToRoute('student_profile');
    }
}