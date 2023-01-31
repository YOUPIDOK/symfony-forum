<?php

namespace App\Controller\Admin;

use App\Entity\JobActivity;
use App\Form\JobActivityType;
use App\Repository\JobActivityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/activité')]
class JobActivityController extends AbstractController
{
    #[Route('/', name: 'admin_job_activity_index', methods: ['GET'])]
    public function index(JobActivityRepository $jobActivityRepository): Response
    {
        return $this->render('pages/admin/job_activity/index.html.twig', [
            'job_activities' => $jobActivityRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_job_activity_new', methods: ['GET', 'POST'])]
    public function new(Request $request, JobActivityRepository $jobActivityRepository): Response
    {
        $jobActivity = new JobActivity();
        $form = $this->createForm(JobActivityType::class, $jobActivity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $jobActivityRepository->save($jobActivity, true);

            return $this->redirectToRoute('admin_job_activity_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/admin/job_activity/new.html.twig', [
            'job_activity' => $jobActivity,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_job_activity_show', methods: ['GET'])]
    public function show(JobActivity $jobActivity): Response
    {
        return $this->render('pages/admin/job_activity/show.html.twig', [
            'job_activity' => $jobActivity,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_job_activity_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, JobActivity $jobActivity, JobActivityRepository $jobActivityRepository): Response
    {
        $form = $this->createForm(JobActivityType::class, $jobActivity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $jobActivityRepository->save($jobActivity, true);

            return $this->redirectToRoute('admin_job_activity_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/admin/job_activity/edit.html.twig', [
            'job_activity' => $jobActivity,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_job_activity_delete', methods: ['POST'])]
    public function delete(Request $request, JobActivity $jobActivity, JobActivityRepository $jobActivityRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$jobActivity->getId(), $request->request->get('_token'))) {
            $jobActivityRepository->remove($jobActivity, true);
        }

        return $this->redirectToRoute('admin_job_activity_index', [], Response::HTTP_SEE_OTHER);
    }
}
