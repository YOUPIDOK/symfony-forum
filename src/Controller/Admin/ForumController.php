<?php

namespace App\Controller\Admin;

use App\Entity\Forum;
use App\Form\ForumType;
use App\Repository\ForumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/forum', name: 'admin_')]
class ForumController extends AbstractController
{
    #[Route('/', name: 'forum_index', methods: ['GET'])]
    public function index(ForumRepository $forumRepository): Response
    {
        return $this->render('pages/admin/forum/index.html.twig', [
            'forums' => $forumRepository->findBy([], ['name' => 'ASC']),
        ]);
    }

    #[Route('/new', name: 'forum_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ForumRepository $forumRepository): Response
    {
        $forum = new Forum();
        $form = $this->createForm(ForumType::class, $forum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $forumRepository->save($forum, true);

            return $this->redirectToRoute('admin_forum_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/admin/forum/new.html.twig', [
            'forum' => $forum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'forum_show', methods: ['GET'])]
    public function show(Forum $forum): Response
    {
        return $this->render('pages/admin/forum/show.html.twig', [
            'forum' => $forum,
        ]);
    }

    #[Route('/{id}/edit', name: 'forum_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Forum $forum, ForumRepository $forumRepository): Response
    {
        $form = $this->createForm(ForumType::class, $forum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $forumRepository->save($forum, true);

            return $this->redirectToRoute('admin_forum_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/admin/forum/edit.html.twig', [
            'forum' => $forum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'forum_delete', methods: ['POST'])]
    public function delete(Request $request, Forum $forum, ForumRepository $forumRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$forum->getId(), $request->request->get('_token'))) {
            $forumRepository->remove($forum, true);
        }

        return $this->redirectToRoute('admin_forum_index', [], Response::HTTP_SEE_OTHER);
    }
}
