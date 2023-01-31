<?php

namespace App\Controller\Admin;

use App\Entity\Survey;
use App\Form\SurveyType;
use App\Repository\SurveyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/survey')]
class SurveyController extends AbstractController
{
    #[Route('/', name: 'admin_survey_index', methods: ['GET'])]
    public function index(SurveyRepository $surveyRepository): Response
    {
        return $this->render('pages/admin/survey/index.html.twig', [
            'surveys' => $surveyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_survey_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SurveyRepository $surveyRepository): Response
    {
        $survey = new Survey();
        $form = $this->createForm(SurveyType::class, $survey);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $surveyRepository->save($survey, true);

            return $this->redirectToRoute('admin_survey_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/admin/survey/new.html.twig', [
            'survey' => $survey,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_survey_show', methods: ['GET'])]
    public function show(Survey $survey): Response
    {
        return $this->render('pages/admin/survey/show.html.twig', [
            'survey' => $survey,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_survey_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Survey $survey, SurveyRepository $surveyRepository): Response
    {
        $form = $this->createForm(SurveyType::class, $survey);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $surveyRepository->save($survey, true);

            return $this->redirectToRoute('admin_survey_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/admin/survey/edit.html.twig', [
            'survey' => $survey,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_survey_delete', methods: ['POST'])]
    public function delete(Request $request, Survey $survey, SurveyRepository $surveyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$survey->getId(), $request->request->get('_token'))) {
            $surveyRepository->remove($survey, true);
        }

        return $this->redirectToRoute('admin_survey_index', [], Response::HTTP_SEE_OTHER);
    }
}
