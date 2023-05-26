<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailArticlesController extends AbstractController
{
    #[Route('/detail/articles/{id}', name: 'app_detail_articles')]
    public function index(int $id, ArticleRepository $articleRepo,CategorieRepository $categorieRepo) : Response
    {
        $categorie = $categorieRepo->findOneBy(["id" => $id]);
        $articles = $articleRepo->findOneBy(["id" => $id]);


        return $this->render('detail_articles/index.html.twig', [
            'articles' => $articles,
            'categorie' => $categorie
        ]);
    }
}
