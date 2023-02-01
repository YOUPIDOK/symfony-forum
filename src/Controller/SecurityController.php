<?php

namespace App\Controller;

use App\Entity\Student;
use App\Enum\UserRoleEnum;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/connexion', name: 'login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            $this->addFlash('warning', 'Vous êtes déja connecté.');

            return $this->redirectToRoute('home');
        }

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('pages/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    #[Route(path: '/deconnexion', name: 'logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/creer-un-compte-etudiant', name: 'register_student')]
    public function registerStudent(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        StudentRepository $studentRepository
    ): Response
    {
        if ($this->getUser()) {
            $this->addFlash('warning', 'Vous êtes déja connecté.');

            return $this->redirectToRoute('home');
        }

        $student = new Student();
        $form = $this->createForm(StudentType::class, $student, ['required_password' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('user')->get('plainPassword')->getData();
            if ($plainPassword != null) {
                $hashedPassword = $passwordHasher->hashPassword($student->getUser(), $plainPassword);
                $student->getUser()->setPassword($hashedPassword);
            }

            $student->getUser()->addRole(UserRoleEnum::ROLE_STUDENT);

            $studentRepository->save($student, true);

            return $this->redirectToRoute('login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/register_student.html.twig', [
            'student' => $student,
            'form' => $form,
        ]);
    }
}