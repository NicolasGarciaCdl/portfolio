<?php

namespace App\Controller;

use App\Entity\Language;
use App\Form\LanguageType;
use App\Repository\LanguageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/language')]
class LanguageController extends AbstractController
{
    #[Route('/', name: 'app_language_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $languages = $entityManager
            ->getRepository(Language::class)
            ->findAll();

        return $this->render('language/index.html.twig', [
            'languages' => $languages,
        ]);
    }

    #[Route('/new', name: 'app_language_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        if($this->isGranted('ROLE_ADMIN')) {
            $language = new Language();
            $form = $this->createForm(LanguageType::class, $language);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $languageToSave = $form->getData();
                $entityManager->persist($languageToSave);
                $entityManager->flush();

                return $this->redirectToRoute('app_language_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('language/new.html.twig', [
                'language' => $language,
                'form'     => $form,
            ]);
        }
        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_language_show', methods: ['GET'])]
    public function show(Language $language): Response
    {
        return $this->render('language/show.html.twig', [
            'language' => $language,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_language_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Language $language, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LanguageType::class, $language);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_language_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('language/edit.html.twig', [
            'language' => $language,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_language_delete', methods: ['POST'])]
    public function delete(Request $request, Language $language, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$language->getId(), $request->request->get('_token'))) {
            $entityManager->remove($language);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_language_index', [], Response::HTTP_SEE_OTHER);
    }
}
