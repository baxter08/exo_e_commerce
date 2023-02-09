<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\SearchType;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{

    
    #[Route('/', name: 'app_index')]
    public function index(ArticleRepository $articleRepos,Request $request): Response
    {
       
        $form = $this->createForm(SearchType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            // dd($form->get('q')->getData());

            // on recherche les article coresponndant au mots de la recherche
            $articles = $articleRepos->search($form->get('q')->getData());

        }
        else{
            $articles = $articleRepos->findAll();
        }
        // $articles = $articleRepos->findAll();
        
        return $this->render('pages/main/index.html.twig', [
            'articles' => $articles ,
            'form' => $form->createView()
          
        ]);
  
    }

    // #[Route('/', name: 'ajax')]
    // public function isXmlHttpRequest($headers)
    // {

    //     $response = new JsonResponse([
    //         'data' => 123,
    //         'code' => 200
    //     ]);

    //     return 'XMLHttpRequest' == $this->$headers->get('search',[
    //         'response' => $response,
    //         'headers' => $headers
    //     ]);

    // }
    
    
    #[Route('/search', name: 'search_text')]
    public function search(ArticleRepository $articleRepo, Request $request,
    ): Response {
        //  dd($request);
    
        if($request) {

            $articles = $articleRepo->search($request->get('mots'));

      
        }else{

            $articles = $articleRepo->findAll();

        }
            
        return $this->render('article/index.html.twig', [
            'controller_name' => 'jp',
            'articles' => $articles
           
        
            
        ]);

    }
    
}


