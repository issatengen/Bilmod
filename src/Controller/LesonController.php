<?php

namespace App\Controller;

use App\Entity\Leson;
use App\Form\LesonForm;
use App\Repository\LesonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/leson')]
final class LesonController extends AbstractController
{
    #[Route(name: 'app_leson_index', methods: ['GET'])]
    public function index(LesonRepository $lesonRepository): Response
    {
        if (!$this->getUser()) {
            // Redirect to login if not authenticated
            return $this->redirectToRoute('app_login');
        }
        return $this->render('leson/index.html.twig', [
            'lesons' => $lesonRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_leson_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $leson = new Leson();
        $form = $this->createForm(LesonForm::class, $leson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($leson);
            $entityManager->flush();

            return $this->redirectToRoute('app_leson_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('leson/new.html.twig', [
            'leson' => $leson,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_leson_show', methods: ['GET'])]
    public function show(Leson $leson): Response
    {
        return $this->render('leson/show.html.twig', [
            'leson' => $leson,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_leson_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Leson $leson, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LesonForm::class, $leson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_leson_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('leson/edit.html.twig', [
            'leson' => $leson,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_leson_delete', methods: ['POST'])]
    public function delete(Request $request, Leson $leson, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$leson->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($leson);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_leson_index', [], Response::HTTP_SEE_OTHER);
    }
}
