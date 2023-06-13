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
    #[Route('/detail/articles/{id}', name: 'app_detail_articles')]
    public function index(int $id, ArticleRepository $articleRepo): Response
    {

        $articles = $articleRepo->findOneBy(["id" => $id]);


        return $this->render('detail_articles/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/article/{slug}-{id<[0-9]+>}', name: 'app_detail_articles_show', requirements: ["slug" => "[a-z0-9\-]*"])]
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
