<?php

namespace App\Controller;

use App\Entity\LesonModule;
use App\Entity\Item;
use App\Form\LesonModuleForm;
use App\Repository\LesonModuleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[Route('/leson/module')]
final class LesonModuleController extends AbstractController
{
    #[Route('{id}', name: 'app_leson_module_index', methods: ['GET'])]
    public function index($id, LesonModuleRepository $lesonModuleRepository, EntityManagerInterface $entityManager): Response
    { 
        $cource=$entityManager->getRepository(Item::class)->find($id);
        return $this->render('leson_module/index.html.twig', [
            'leson_modules' => $lesonModuleRepository->findBy(['leson' => $cource]),
            'cource' => $cource
        ]);
    }

    #[Route('/new{id}', name: 'app_leson_module_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        $id, 
        EntityManagerInterface $entityManager,
        #[autowire('uploaded_file')] string $location
        ): Response
    {
        $lesonModule = new LesonModule();
        $form = $this->createForm(LesonModuleForm::class, $lesonModule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = uniqid().'.'.$image->guessExtension();
                try {
                    $image->move(
                        $location,
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'File upload failed: '.$e->getMessage());
                }
                $lesonModule->setImage($newFilename);
            }

            $lesonId=$entityManager->getRepository(Item::class)->find($id);
            if (!$lesonId) {
                $this->addFlash('error', 'Leson not found.');
            }
            $lesonModule->setLeson($lesonId);
            $entityManager->persist($lesonModule);
            $entityManager->flush();
            $this->addFlash('success', 'Leson Module created successfully.');

            return $this->redirectToRoute('app_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('leson_module/new.html.twig', [
            'leson_module' => $lesonModule,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_leson_module_show', methods: ['GET'])]
    public function show(LesonModule $lesonModule): Response
    {
        return $this->render('leson_module/show.html.twig', [
            'leson_module' => $lesonModule,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_leson_module_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, LesonModule $lesonModule, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LesonModuleForm::class, $lesonModule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Leson Module updated successfully.');
 
            return $this->redirectToRoute('app_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('leson_module/edit.html.twig', [
            'leson_module' => $lesonModule,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_leson_module_delete', methods: ['POST'])]
    public function delete(Request $request, LesonModule $lesonModule, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lesonModule->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($lesonModule);
            $entityManager->flush();
            $this->addFlash('success', 'Leson Module deleted successfully.');
        }

        return $this->redirectToRoute('app_leson_module_index', [], Response::HTTP_SEE_OTHER);
    }
}
