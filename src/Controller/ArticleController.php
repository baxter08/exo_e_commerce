<?php

namespace App\Controller;

use App\Entity\Article;
use App\Model\SearchData;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\request;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    public function index(ArticleRepository $articleRepo
    ): Response {
        // $searchData = new SearchData();
        // $form = $this->createForm(SearchType::class, $searchData);

        // $form->handleRequest($request);
        // if ($form->isSubmitted() && $form->isValid()){
        //     dd($searchData);
        // }

        $articles = $articleRepo->findAll();

        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
            'articles' => $articles
        
            
        ]);

    }
}
// #[Route('/produit/{slug}', name: 'product')]
//     public function show($): Response
//     {
//         // dd($slug);
//         $product = $this->entityManager->getRepository(Product::class)->findBySlug($slug);
//         // dd($products);
//         if (!$product) {

//             return $this->redirectToRoute('app_product');
//         }

//              return $this->render('product/show.html.twig', [
//             'product' => $product
//         ]);





