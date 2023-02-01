<?php

namespace App\Controller\Admin;

use App\Entity\Company;
use App\Form\CompanyType;
use App\Repository\CompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/entreprise')]
class CompanyController extends AbstractController
{
    #[Route('/', name: 'admin_company_index', methods: ['GET'])]
    public function index(CompanyRepository $companyRepository): Response
    {
        return $this->render('pages/admin/company/index.html.twig', [
            'companies' => $companyRepository->findBy([], ['name' => 'ASC']),
        ]);
    }

    #[Route('/new', name: 'admin_company_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CompanyRepository $companyRepository): Response
    {
        $company = new Company();
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $companyRepository->save($company, true);

            return $this->redirectToRoute('admin_company_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/admin/company/new.html.twig', [
            'company' => $company,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_company_show', methods: ['GET'])]
    public function show(Company $company): Response
    {
        return $this->render('pages/admin/company/show.html.twig', [
            'company' => $company,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_company_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Company $company, CompanyRepository $companyRepository): Response
    {
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $companyRepository->save($company, true);

            return $this->redirectToRoute('admin_company_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/admin/company/edit.html.twig', [
            'company' => $company,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_company_delete', methods: ['POST'])]
    public function delete(Request $request, Company $company, CompanyRepository $companyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$company->getId(), $request->request->get('_token'))) {
            $companyRepository->remove($company, true);
        }

        return $this->redirectToRoute('admin_company_index', [], Response::HTTP_SEE_OTHER);
    }
}
