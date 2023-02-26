<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\OrderItem;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    public function index(ArticleRepository $articleRepo
    ): Response {

        $articles = $articleRepo->findAll();

        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
            'articles' => $articles
        
            
        ]);

    }

     /**
     * @param EntityManagerInterface $entityManager
     * @param int $limit
     * @return array
     */
    public static function getBestSellingArticles(EntityManagerInterface $entityManager, int $limit = 10): array
    {
        $bestSellingArticles = $entityManager->getRepository(OrderItem::class)->getBestSellingArticles();
        $queryBuilder = $entityManager->createQueryBuilder();

        $queryBuilder
            ->select('article', 'SUM(item.quantity) as totalQuantity')
            ->from(OrderItem::class, 'item')
            ->join('item.article', 'article')
            ->groupBy('article')
            ->orderBy('totalQuantity', 'DESC')
            ->setMaxResults($limit);

        $query = $queryBuilder->getQuery();

        return $query->getResult([
            'bestSellingArticles' => $bestSellingArticles
        ]
            );
        
    }

    #[Route('/search', name: 're')]
    public function search(ArticleRepository $articleRepo, Request $request,
    ): Response {
        //  dd($request,);
    
        if($request) {

        
            $articles = $articleRepo->search($request->get('mots'));

            // dd($articles);

      
        }else{

            $articles = $articleRepo->findAll();

        }

        return $this->render('article/index.html.twig', [
            'controller_name' => 'jp',
            'articles' => $articles,
           
           
        
            
        ]);
        

    }
    
    #[Route('/result', name: 'app_result')]
public function result(ArticleRepository $articleRepo, Request $request)
{
    $articles = $articleRepo->search($request->get('keywords'));
    $keywords = $request->get('keywords');

    return $this->render('pages/main/result.html.twig', [
        'articles' => $articles,
        'keywords' => $keywords
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





