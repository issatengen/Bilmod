<?php

namespace App\Controller;

use App\Entity\StudentCourse;
use App\Form\StudentCourseForm;
use App\Repository\StudentCourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/student/course')]
final class StudentCourseController extends AbstractController
{
    #[Route(name: 'app_student_course_index', methods: ['GET'])]
    public function index(StudentCourseRepository $studentCourseRepository): Response
    {
        if (!$this->getUser()) {
            // Redirect to login if not authenticated
            return $this->redirectToRoute('app_login');
        }
        return $this->render('student_course/index.html.twig', [
            'student_courses' => $studentCourseRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_student_course_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $studentCourse = new StudentCourse();
        $form = $this->createForm(StudentCourseForm::class, $studentCourse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($studentCourse);
            $entityManager->flush();

            return $this->redirectToRoute('app_student_course_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('student_course/new.html.twig', [
            'student_course' => $studentCourse,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_student_course_show', methods: ['GET'])]
    public function show(StudentCourse $studentCourse): Response
    {
        return $this->render('student_course/show.html.twig', [
            'student_course' => $studentCourse,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_student_course_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, StudentCourse $studentCourse, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StudentCourseForm::class, $studentCourse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_student_course_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('student_course/edit.html.twig', [
            'student_course' => $studentCourse,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_student_course_delete', methods: ['POST'])]
    public function delete(Request $request, StudentCourse $studentCourse, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$studentCourse->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($studentCourse);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_student_course_index', [], Response::HTTP_SEE_OTHER);
    }
}
