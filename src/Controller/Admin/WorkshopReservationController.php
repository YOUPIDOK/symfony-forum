<?php

namespace App\Controller\Admin;

use App\Entity\WorkshopReservation;
use App\Form\WorkshopReservationType;
use App\Repository\WorkshopReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/inscription-au-atelier')]
class WorkshopReservationController extends AbstractController
{
    #[Route('/', name: 'admin_workshop_reservation_index', methods: ['GET'])]
    public function index(WorkshopReservationRepository $workshopReservationRepository): Response
    {
        return $this->render('pages/admin/workshop_reservation/index.html.twig', [
            'workshop_reservations' => $workshopReservationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_workshop_reservation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, WorkshopReservationRepository $workshopReservationRepository): Response
    {
        $workshopReservation = new WorkshopReservation();
        $form = $this->createForm(WorkshopReservationType::class, $workshopReservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $workshopReservationRepository->save($workshopReservation, true);

            return $this->redirectToRoute('admin_workshop_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/admin/workshop_reservation/new.html.twig', [
            'workshop_reservation' => $workshopReservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_workshop_reservation_show', methods: ['GET'])]
    public function show(WorkshopReservation $workshopReservation): Response
    {
        return $this->render('pages/admin/workshop_reservation/show.html.twig', [
            'workshop_reservation' => $workshopReservation,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_workshop_reservation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, WorkshopReservation $workshopReservation, WorkshopReservationRepository $workshopReservationRepository): Response
    {
        $form = $this->createForm(WorkshopReservationType::class, $workshopReservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $workshopReservationRepository->save($workshopReservation, true);

            return $this->redirectToRoute('admin_workshop_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/admin/workshop_reservation/edit.html.twig', [
            'workshop_reservation' => $workshopReservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_workshop_reservation_delete', methods: ['POST'])]
    public function delete(Request $request, WorkshopReservation $workshopReservation, WorkshopReservationRepository $workshopReservationRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$workshopReservation->getId(), $request->request->get('_token'))) {
            $workshopReservationRepository->remove($workshopReservation, true);
        }

        return $this->redirectToRoute('admin_workshop_reservation_index', [], Response::HTTP_SEE_OTHER);
    }
}
