<?php

namespace App\Controller\Admin;

use App\Entity\WorkshopSector;
use App\Form\WorkshopSectorType;
use App\Repository\WorkshopSectorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/secteur')]
class WorkshopSectorController extends AbstractController
{
    #[Route('/', name: 'admin_workshop_sector_index', methods: ['GET'])]
    public function index(WorkshopSectorRepository $workshopSectorRepository): Response
    {
        return $this->render('pages/admin/workshop_sector/index.html.twig', [
            'workshop_sectors' => $workshopSectorRepository->findBy([], ['name' => 'ASC']),
        ]);
    }

    #[Route('/new', name: 'admin_workshop_sector_new', methods: ['GET', 'POST'])]
    public function new(Request $request, WorkshopSectorRepository $workshopSectorRepository): Response
    {
        $workshopSector = new WorkshopSector();
        $form = $this->createForm(WorkshopSectorType::class, $workshopSector);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $workshopSectorRepository->save($workshopSector, true);

            return $this->redirectToRoute('admin_workshop_sector_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/admin/workshop_sector/new.html.twig', [
            'workshop_sector' => $workshopSector,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_workshop_sector_show', methods: ['GET'])]
    public function show(WorkshopSector $workshopSector): Response
    {
        return $this->render('pages/admin/workshop_sector/show.html.twig', [
            'workshop_sector' => $workshopSector,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_workshop_sector_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, WorkshopSector $workshopSector, WorkshopSectorRepository $workshopSectorRepository): Response
    {
        $form = $this->createForm(WorkshopSectorType::class, $workshopSector);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $workshopSectorRepository->save($workshopSector, true);

            return $this->redirectToRoute('admin_workshop_sector_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/admin/workshop_sector/edit.html.twig', [
            'workshop_sector' => $workshopSector,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_workshop_sector_delete', methods: ['POST'])]
    public function delete(Request $request, WorkshopSector $workshopSector, WorkshopSectorRepository $workshopSectorRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$workshopSector->getId(), $request->request->get('_token'))) {
            $workshopSectorRepository->remove($workshopSector, true);
        }

        return $this->redirectToRoute('admin_workshop_sector_index', [], Response::HTTP_SEE_OTHER);
    }
}
