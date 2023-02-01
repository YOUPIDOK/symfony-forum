<?php

namespace App\Controller\Admin;

use App\Entity\Workshop;
use App\Form\WorkshopType;
use App\Repository\WorkshopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/atelier')]
class WorkshopController extends AbstractController
{
    #[Route('/', name: 'admin_workshop_index', methods: ['GET'])]
    public function index(WorkshopRepository $workshopRepository): Response
    {
        return $this->render('pages/admin/workshop/index.html.twig', [
            'workshops' => $workshopRepository->findBy([], ['name' => 'ASC']),
        ]);
    }

    #[Route('/new', name: 'admin_workshop_new', methods: ['GET', 'POST'])]
    public function new(Request $request, WorkshopRepository $workshopRepository): Response
    {
        $workshop = new Workshop();
        $form = $this->createForm(WorkshopType::class, $workshop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $workshopRepository->save($workshop, true);

            return $this->redirectToRoute('admin_workshop_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/admin/workshop/new.html.twig', [
            'workshop' => $workshop,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_workshop_show', methods: ['GET'])]
    public function show(Workshop $workshop): Response
    {
        return $this->render('pages/admin/workshop/show.html.twig', [
            'workshop' => $workshop,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_workshop_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Workshop $workshop, WorkshopRepository $workshopRepository): Response
    {
        $form = $this->createForm(WorkshopType::class, $workshop);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $workshopRepository->save($workshop, true);

            return $this->redirectToRoute('admin_workshop_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/admin/workshop/edit.html.twig', [
            'workshop' => $workshop,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_workshop_delete', methods: ['POST'])]
    public function delete(Request $request, Workshop $workshop, WorkshopRepository $workshopRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$workshop->getId(), $request->request->get('_token'))) {
            $workshopRepository->remove($workshop, true);
        }

        return $this->redirectToRoute('admin_workshop_index', [], Response::HTTP_SEE_OTHER);
    }
}
