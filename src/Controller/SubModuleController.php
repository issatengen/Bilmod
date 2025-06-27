<?php

namespace App\Controller;

use App\Entity\SubModule;
use App\Entity\LesonModule;
use App\Form\SubModuleForm;
use App\Repository\SubModuleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[Route('/sub/module')]
final class SubModuleController extends AbstractController
{
    #[Route('{id}', name: 'app_sub_module_index', methods: ['GET'])]
    public function index($id, EntityManagerInterface $entityManager, SubModuleRepository $subModuleRepository): Response
    {
        $module = $entityManager->getRepository(LesonModule::class)->find($id);

        if (!$module) {
            throw $this->createNotFoundException('Module not found');
        }

        $subModules = $subModuleRepository->findBy(['module' => $module]);

        return $this->render('sub_module/index.html.twig', [
            'sub_modules' => $subModules,
            'module' => $module,
        ]);
    }

    #[Route('/new{id}', name: 'app_sub_module_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request, 
        $id, 
        EntityManagerInterface $entityManager,
        #[autowire('upload_images')] string $location
        ): Response
    {
        $subModule = new SubModule();
        $form = $this->createForm(SubModuleForm::class, $subModule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $image = $form->get('image')->getData();
            if($image){
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = uniqid().'.'.$image->guessExtension();
                try {
                    $image->move( 
                        $location,
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Handle exception if something happens during file upload
                }
                $subModule->setImage($newFilename);
            }

            $lesonModule = $entityManager->getRepository(LesonModule::class)->find($id);
            if (!$lesonModule) {
                $this->addFlash('Leson Module not found');
            }
            $subModule->setModule($lesonModule);
            $entityManager->persist($subModule);
            $entityManager->flush();
            $this->addFlash('success', 'Sub Module created successfully.');

            return $this->redirectToRoute('app_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sub_module/new.html.twig', [
            'sub_module' => $subModule,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sub_module_show', methods: ['GET'])]
    public function show(SubModule $subModule): Response
    {
        return $this->render('sub_module/show.html.twig', [
            'sub_module' => $subModule,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_sub_module_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SubModule $subModule, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SubModuleForm::class, $subModule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Sub Module updated successfully.');

            return $this->redirectToRoute('app_item_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sub_module/edit.html.twig', [
            'sub_module' => $subModule,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sub_module_delete', methods: ['POST'])]
    public function delete(Request $request, SubModule $subModule, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subModule->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($subModule);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_item_index', [], Response::HTTP_SEE_OTHER);
    }
}
