<?php

namespace App\Controller\Admin;

use App\Entity\Resource;
use App\Enum\ResourceTypeEnum;
use App\Form\ResourceType;
use App\Repository\ResourceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/resource')]
class ResourceController extends AbstractController
{
    #[Route('/', name: 'admin_resource_index', methods: ['GET'])]
    public function index(ResourceRepository $resourceRepository): Response
    {
        return $this->render('pages/admin/resource/index.html.twig', [
            'resources' => $resourceRepository->findAll(),
        ]);
    }

    #[Route('/new-url', name: 'admin_resource_new_url', methods: ['GET', 'POST'])]
    public function newUrl(Request $request, ResourceRepository $resourceRepository): Response
    {
        $resource = (new Resource())->setType(ResourceTypeEnum::URL);

        $form = $this->createForm(ResourceType::class, $resource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $resourceRepository->save($resource, true);

            return $this->redirectToRoute('admin_resource_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/admin/resource/new.html.twig', [
            'resource' => $resource,
            'form' => $form,
        ]);
    }

    #[Route('/new-file', name: 'admin_resource_new_file', methods: ['GET', 'POST'])]
    public function newFile(Request $request, ResourceRepository $resourceRepository): Response
    {
        $resource = (new Resource())->setType(ResourceTypeEnum::FILE);

        $form = $this->createForm(ResourceType::class, $resource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $resourceRepository->save($resource, true);

            return $this->redirectToRoute('admin_resource_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/admin/resource/new.html.twig', [
            'resource' => $resource,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_resource_show', methods: ['GET'])]
    public function show(Resource $resource): Response
    {
        return $this->render('pages/admin/resource/show.html.twig', [
            'resource' => $resource,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_resource_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Resource $resource, ResourceRepository $resourceRepository): Response
    {
        $form = $this->createForm(ResourceType::class, $resource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $resourceRepository->save($resource, true);

            return $this->redirectToRoute('admin_resource_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/admin/resource/edit.html.twig', [
            'resource' => $resource,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_resource_delete', methods: ['POST'])]
    public function delete(Request $request, Resource $resource, ResourceRepository $resourceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$resource->getId(), $request->request->get('_token'))) {
            $resourceRepository->remove($resource, true);
        }

        return $this->redirectToRoute('admin_resource_index', [], Response::HTTP_SEE_OTHER);
    }
}
