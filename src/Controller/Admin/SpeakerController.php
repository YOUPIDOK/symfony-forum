<?php

namespace App\Controller\Admin;

use App\Entity\Speaker;
use App\Entity\User;
use App\Enum\UserRoleEnum;
use App\Form\SpeakerType;
use App\Repository\SpeakerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/intervenant')]
class SpeakerController extends AbstractController
{
    #[Route('/', name: 'admin_speaker_index', methods: ['GET'])]
    public function index(SpeakerRepository $speakerRepository): Response
    {
        return $this->render('pages/admin/speaker/index.html.twig', [
            'speakers' => $speakerRepository->findBy([], []),
        ]);
    }

    #[Route('/new', name: 'admin_speaker_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SpeakerRepository $speakerRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $speaker = new Speaker();
        $form = $this->createForm(SpeakerType::class, $speaker, ['required_password' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('user')->get('plainPassword')->getData();
            if ($plainPassword != null) {
                $hashedPassword = $passwordHasher->hashPassword($speaker->getUser(), $plainPassword);
                $speaker->getUser()->setPassword($hashedPassword);
            }
            $speaker->getUser()->addRole(UserRoleEnum::ROLE_SPEAKER);
            $speakerRepository->save($speaker, true);


            return $this->redirectToRoute('admin_speaker_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/admin/speaker/new.html.twig', [
            'speaker' => $speaker,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_speaker_show', methods: ['GET'])]
    public function show(Speaker $speaker): Response
    {
        return $this->render('pages/admin/speaker/show.html.twig', [
            'speaker' => $speaker,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_speaker_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Speaker $speaker, SpeakerRepository $speakerRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(SpeakerType::class, $speaker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('user')->get('plainPassword')->getData();
            if ($plainPassword != null) {
                $hashedPassword = $passwordHasher->hashPassword($speaker->getUser(), $plainPassword);
                $speaker->getUser()->setPassword($hashedPassword);
            }
            $speakerRepository->save($speaker, true);

            return $this->redirectToRoute('admin_speaker_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/admin/speaker/edit.html.twig', [
            'speaker' => $speaker,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_speaker_delete', methods: ['POST'])]
    public function delete(Request $request, Speaker $speaker, SpeakerRepository $speakerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$speaker->getId(), $request->request->get('_token'))) {
            $speakerRepository->remove($speaker, true);
        }

        return $this->redirectToRoute('admin_speaker_index', [], Response::HTTP_SEE_OTHER);
    }
}
