<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use App\Services\CallApiService;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/blog')]
class ArticleController extends AbstractController
{


    #[Route('/', name: 'app_article_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager, CallApiService $callApiService): Response
    {
        $articles = $entityManager
            ->getRepository(Article::class)
            ->findAll();

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
            'data'=> $callApiService->getLast()
        ]);
    }

    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        if($this->isGranted('ROLE_ADMIN')){

            $article = new Article();
            $form = $this->createForm(ArticleType::class, $article);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $article->setCreatedAt(new \DateTime());
                $article->setUpdatedAt(new \DateTime());
                $article->setUser($this->getUser());
                $entityManager->persist($article);
                $entityManager->flush();

                return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('article/new.html.twig', [
                'article' => $article,
                'form' => $form,
            ]);
        }
        return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_article_show', methods: ['GET', 'POST'])]
    public function show($id, ArticleRepository $articleRepository, Request $request, EntityManagerInterface $entityManager, UserRepository $userRepo): Response
    {
        $comments = $entityManager->getRepository(Comment::class)->findBy(['article' => $id]);
        $article = $articleRepository->findOneBy(['id' => $id]);
        $comment = new Comment();
        $comment->setCreatedAt(new \DateTime());

        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);

        if($commentForm->isSubmitted() && $commentForm->isValid()){
            $comment = $commentForm->getData();
            $comment->setUser($userRepo->findOneBy(['id'=> $this->getUser()]));
            $comment->setArticle($article);
            $comment->setCreatedAt(new \DateTime());
            $comment->setUpdatedAt(new \DateTime());
            $entityManager->persist($comment);
            $entityManager->flush();
            return $this->redirectToRoute('app_article_show', ['id'=> $id]);
        }
        return $this->renderForm('article/show.html.twig', [
            'article' => $article,
            'commentForm' => $commentForm,
            'comments' =>   $comments
        ]);
    }

    #[Route('/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    }
}
