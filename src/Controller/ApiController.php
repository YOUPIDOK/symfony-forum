<?php

namespace App\Controller;

use App\Repository\ForumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api')]
class ApiController extends AbstractController
{
    #[Route('/atelier', name: '_workshop')]
    public function index(ForumRepository $forumRepository): Response
    {
        $data = [];
        $forum = $forumRepository->findLastForum();

        if ($forum !== null) {
            foreach ($forum->getWorkshops() as $workshop) {
                $data[] = [
                    'workshop' => $workshop->getName(),
                    'sector' => $workshop->getSector()->getName(),
                    'jobs' => explode(',', implode(',', $workshop->getJobs()->toArray())),
                    'startAt'  => $workshop->getStartAt(),
                    'endAt'  => $workshop->getEndAt(),
                    'nbReservation'  => $workshop->getWorkshopReservations()->count(),
                ];
            }
        }

        return new JsonResponse($data);
    }
}