<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\SearchType;
use App\Entity\Categorie;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{


    #[Route('/', name: 'app_index')]
    public function index(ArticleRepository $articleRepos, Request $request, CategorieRepository $categorieRepos): Response
    {

        $form = $this->createForm(SearchType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        

            // on recherche les article coresponndant au mots de la recherche
            $articles = $articleRepos->search($form->get('q')->getData());
        } else {
            $articles = $articleRepos->findAll();
        }
      
        $categorie = $categorieRepos->findAll();
        
       
        return $this->render('pages/main/index.html.twig', [
            'articles' => $articles,
            'form' => $form->createView(),
            'categorie' => $categorie, // Ajoutez cette ligne pour passer la variable à la vue
        ]);
    }



    #[Route('/', name: 'search_text')]
    public function search(
        ArticleRepository $articleRepo,
        Request $request,
    ): Response {
     

        if ($request) {

            $articles = $articleRepo->search($request->get('mots'));
        } else {

            $articles = $articleRepo->findAll();
        }

        return $this->render('article/index.html.twig', [
            'controller_name' => 'jp',
            'articles' => $articles



        ]);
    }
}
