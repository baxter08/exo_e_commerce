<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
}
