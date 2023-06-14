<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DetailArticlesController extends AbstractController
{
    #[Route('/detail/articles/{slug}', name: 'app_detail_articles')]
    public function index(string $slug, ArticleRepository $articleRepo, Request $request): Response
    {
        $article = $articleRepo->findOneBy(['slug' => $slug]);

        if (!$article) {
            throw new NotFoundHttpException('Article introuvable');
        }

        // Accéder à la catégorie associée à l'article
        $categorie = $article->getCategorie();

        return $this->render('detail_articles/index.html.twig', [
            'slug' => $slug,
            'categorie' => $categorie,
        ]);
    }
}