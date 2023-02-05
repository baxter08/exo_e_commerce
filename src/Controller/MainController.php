<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    
    #[Route('/', name: 'app_index')]
    public function index(ArticleRepository $articleRepos): Response
    {
            $articles = $articleRepos->findall() ;

        return $this->render('pages/main/index.html.twig', [
            'controller_name' => 'jp',
            'articles' => $articles ,
        ]);

       
        
    }
}


