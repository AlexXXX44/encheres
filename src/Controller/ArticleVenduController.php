<?php

namespace App\Controller;

use App\Entity\ArticleVendu;
use App\Form\ArticleVenduTypeForm;
use App\Repository\ArticleVenduRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArticleVenduController extends AbstractController
{
    #[Route('/article/vendu', name: 'app_article_vendu')]
    #[Route('/', name: 'app_articlevendu_index', methods: ['GET'])]
    public function index(ArticleVenduRepository $articleVenduRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleVenduRepository->findAll()
        ]);
    }

    #[Route('/new', name: 'app_articlevendu_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager)
    {
        $article = new ArticleVendu();
        $form = $this->createForm(ArticleVenduTypeForm::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('app_articlevendu_index');
        }

        return $this->render('article/new.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/{id}', name: 'article_show', methods: ['GET'])]
    public function show(#[MapEntity(mapping: ['id' => 'noArticle'])] ArticleVendu $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ArticleVendu $articleVendu, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(ArticleVenduTypeForm::class, $articleVendu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
//            $entityManager->persist($form);
            $entityManager->flush();

            return $this->redirectToRoute('app_articlevendu_index');
        }

        return $this->render('article/edit.html.twig', [
            'form' => $form,
            'article' => $articleVendu
        ]);
    }

    #[Route('/{id}', name: 'article_delete', methods: ['POST'])]
    public function delete(Request $request, ArticleVendu $article, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $em->remove($article);
            $em->flush();
        }

        return $this->redirectToRoute('app_articlevendu_index');
    }
}
