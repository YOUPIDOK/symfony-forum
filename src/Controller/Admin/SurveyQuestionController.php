<?php

namespace App\Controller\Admin;

use App\Entity\SurveyQuestion;
use App\Form\SurveyQuestionType;
use App\Repository\SurveyQuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/question')]
class SurveyQuestionController extends AbstractController
{
    #[Route('/', name: 'admin_survey_question_index', methods: ['GET'])]
    public function index(SurveyQuestionRepository $surveyQuestionRepository): Response
    {
        return $this->render('pages/admin/survey_question/index.html.twig', [
            'survey_questions' => $surveyQuestionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_survey_question_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SurveyQuestionRepository $surveyQuestionRepository): Response
    {
        $surveyQuestion = new SurveyQuestion();
        $form = $this->createForm(SurveyQuestionType::class, $surveyQuestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $surveyQuestionRepository->save($surveyQuestion, true);

            return $this->redirectToRoute('admin_survey_question_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/admin/survey_question/new.html.twig', [
            'survey_question' => $surveyQuestion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_survey_question_show', methods: ['GET'])]
    public function show(SurveyQuestion $surveyQuestion): Response
    {
        return $this->render('pages/admin/survey_question/show.html.twig', [
            'survey_question' => $surveyQuestion,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_survey_question_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SurveyQuestion $surveyQuestion, SurveyQuestionRepository $surveyQuestionRepository): Response
    {
        $form = $this->createForm(SurveyQuestionType::class, $surveyQuestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $surveyQuestionRepository->save($surveyQuestion, true);

            return $this->redirectToRoute('admin_survey_question_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/admin/survey_question/edit.html.twig', [
            'survey_question' => $surveyQuestion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_survey_question_delete', methods: ['POST'])]
    public function delete(Request $request, SurveyQuestion $surveyQuestion, SurveyQuestionRepository $surveyQuestionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$surveyQuestion->getId(), $request->request->get('_token'))) {
            $surveyQuestionRepository->remove($surveyQuestion, true);
        }

        return $this->redirectToRoute('admin_survey_question_index', [], Response::HTTP_SEE_OTHER);
    }
}
