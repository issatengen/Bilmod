<?php

namespace App\Controller;

use App\Entity\AdminUsers;
use App\Form\AdminUsersForm;
use App\Repository\AdminUsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/admin/users')]
final class AdminUsersController extends AbstractController
{
    #[Route(name: 'app_admin_users_index', methods: ['GET'])]
    public function index(AdminUsersRepository $adminUsersRepository): Response
    {
        if ($this->getUser()) {
            if ($this->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('app_admin_users_index');
            }
            // Add more role checks as needed
            return $this->render('admin_users/index.html.twig', [
            'admin_users' => $adminUsersRepository->findAll(),
        ]);
        } else {
            // Redirect to login if not authenticated
            return $this->redirectToRoute('app_login');
        }
    
    }

    #[Route('/new', name: 'app_admin_users_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $adminUser = new AdminUsers();
        $form = $this->createForm(AdminUsersForm::class, $adminUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Hash the password before saving
            $plainPassword = $form->get('password')->getData();
            $hashedPassword = $passwordHasher->hashPassword($adminUser, $plainPassword);
            $adminUser->setPassword($hashedPassword);

            $entityManager->persist($adminUser);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_users_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_users/new.html.twig', [
            'admin_user' => $adminUser,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_users_show', methods: ['GET'])]
    public function show(AdminUsers $adminUser): Response
    {
        return $this->render('admin_users/show.html.twig', [
            'admin_user' => $adminUser,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_users_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AdminUsers $adminUser, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdminUsersForm::class, $adminUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_users_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_users/edit.html.twig', [
            'admin_user' => $adminUser,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_users_delete', methods: ['POST'])]
    public function delete(Request $request, AdminUsers $adminUser, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$adminUser->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($adminUser);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_users_index', [], Response::HTTP_SEE_OTHER);
    }
}
