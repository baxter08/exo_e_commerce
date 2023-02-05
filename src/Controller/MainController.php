<?php

namespace App\Controller;

use App\Entity\Article;
use App\Model\SearchData;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{

    
    #[Route('/', name: 'app_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepos, Request $request, PostRepository $postRepository): Response
    {  
        $articles = $articleRepos->findall() ;

        $searchData = new SearchData();
             $form = $this->createForm(SearchType::class, $searchData);
                
             $form->handleRequest($request);
             if ($form->isSubmitted() && $form->isValid()) {
                 dd($searchData);
    }
          

        return $this->render('pages/main/index.html.twig', [
            'controller_name' => 'jp',
            'articles' => $articles ,
            'app' => $postRepository->findPublished($request->query->getInt('page', 1))
        ]);

       
        
    }
}

