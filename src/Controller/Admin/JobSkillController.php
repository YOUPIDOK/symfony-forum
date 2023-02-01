<?php

namespace App\Controller\Admin;

use App\Entity\JobSkill;
use App\Form\JobSkillType;
use App\Repository\JobSkillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/competences')]
class JobSkillController extends AbstractController
{
    #[Route('/', name: 'admin_job_skill_index', methods: ['GET'])]
    public function index(JobSkillRepository $jobSkillRepository): Response
    {
        return $this->render('pages/admin/job_skill/index.html.twig', [
            'job_skills' => $jobSkillRepository->findBy([], ['name' => 'ASC']),
        ]);
    }

    #[Route('/new', name: 'admin_job_skill_new', methods: ['GET', 'POST'])]
    public function new(Request $request, JobSkillRepository $jobSkillRepository): Response
    {
        $jobSkill = new JobSkill();
        $form = $this->createForm(JobSkillType::class, $jobSkill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $jobSkillRepository->save($jobSkill, true);

            return $this->redirectToRoute('admin_job_skill_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/admin/job_skill/new.html.twig', [
            'job_skill' => $jobSkill,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_job_skill_show', methods: ['GET'])]
    public function show(JobSkill $jobSkill): Response
    {
        return $this->render('pages/admin/job_skill/show.html.twig', [
            'job_skill' => $jobSkill,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_job_skill_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, JobSkill $jobSkill, JobSkillRepository $jobSkillRepository): Response
    {
        $form = $this->createForm(JobSkillType::class, $jobSkill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $jobSkillRepository->save($jobSkill, true);

            return $this->redirectToRoute('admin_job_skill_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/admin/job_skill/edit.html.twig', [
            'job_skill' => $jobSkill,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_job_skill_delete', methods: ['POST'])]
    public function delete(Request $request, JobSkill $jobSkill, JobSkillRepository $jobSkillRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$jobSkill->getId(), $request->request->get('_token'))) {
            $jobSkillRepository->remove($jobSkill, true);
        }

        return $this->redirectToRoute('admin_job_skill_index', [], Response::HTTP_SEE_OTHER);
    }
}
