<?php

namespace App\Controller;

use App\Entity\Article;
use App\Util\SlugifyUtil;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DetailArticlesController extends AbstractController
{
    #[Route('/detail/articles/{slug}', name: 'app_detail_articles')]
    public function index(Article $article): Response
    {
        return $this->render('detail_articles/index.html.twig', [
            'article' => $article,
        ]);
    }

    // #[Route('/detail/article/{slug}', name: 'app_detail_articles_show', requirements: ["slug" => "[a-z0-9\-]*"])]
    #[Route('/detail/article/{slug}', name: 'app_detail_articles_show')]
    public function show(Article $article, string $slug, int $id): Response
    {
        $slugFromId = SlugifyUtil::slugify($id);
        
        if (!$article || $slugFromId !== $slug) {
            throw new NotFoundHttpException('Article not found');
        }
    
        if ($slugFromId !== $slug) {
            return $this->redirectToRoute('app_detail_article_show', [
                'id' => $article->getId(),
                'slug' => $slugFromId,
            ], 301);
        }
    
        return $this->render('article/show.html.twig', [
            'article' => $article,
            'id' => $id,
            'js_file' => 'assets/index.js', // Chemin vers votre fichier JavaScript
        ]);
    }
}
