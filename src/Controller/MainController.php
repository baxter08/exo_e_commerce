<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{

    
    #[Route('/', name: 'app_index')]
    public function index(ArticleRepository $articleRepos): Response
    {
       
        $articles = $articleRepos->findAll();
        return $this->render('pages/main/index.html.twig', [
            'controller_name' => 'jp',
            'articles' => $articles ,
          
        ]);

       
        
    }
}


