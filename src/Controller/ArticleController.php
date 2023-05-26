<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    public function index(ArticleRepository $articleRepo, EntityManagerInterface $entityManager,CategorieRepository $categorieRepos, ): Response {

        $articles = $articleRepo->findAll();
        
        $query = $entityManager->createQuery(
            'SELECT c
            FROM App\Entity\Commande c
            ORDER BY c.montant DESC'
        )->setMaxResults(10);
        // dd($articles);
        $commandes = $query->getResult();
        // $categorie = $categorieRepos->find();

        $categorieId = 1; // Remplacez 1 par l'ID de la catégorie souhaitée
        $categorie = $categorieRepos->findAll();

        if (!$categorie) {
            throw $this->createNotFoundException('La catégorie spécifiée n\'existe pas.');
        }

        $queryBuilder = $articleRepo->createQueryBuilder('a')
            ->innerJoin('a.categories', 'c')
            ->where('c.id = :categorieId')
            ->setParameter('categorieId', $categorieId);

        $articles = $queryBuilder->getQuery()->getResult();

        $commandes = $query->getResult();

        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
            'articles' => $articles,
            'commandes' => $commandes,
            'categorie' => $categorie,
        
            
        ]);

    }
    #[Route('/article', name: 'article')]
         public function showArticlesByCategory(CategorieRepository $categorieRepo): Response {
           $categorieId = 1; // Remplacez 1 par l'ID de la catégorie souhaitée
           $categorie = $categorieRepo->find($categorieId);
    
           if (!$categorie) {
                 throw $this->createNotFoundException('La catégorie spécifiée n\'existe pas.');
           }
    
             $articles = $categorie->getArticles();
    // // dd($articles);
             return $this->render('article/index.html.twig', [
                 'articles' => $articles,
                'categorie' => $categorie,
             ]);
    }
    public function getBestSellingArticles(EntityManagerInterface $entityManager, int $limit = 10): array
{
    $queryBuilder = $entityManager->createQueryBuilder();

    $queryBuilder
        ->select('article', 'SUM(item.quantity) as totalQuantity')
        ->from(OrderItem::class, 'item')
        ->join('item.article', 'article')
        ->groupBy('article')
        ->orderBy('totalQuantity', 'DESC')
        ->setMaxResults($limit);

    $query = $queryBuilder->getQuery();
   

    return $query->getResult();
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


public function configureFields(string $imageNom): iterable
{
    yield ImageField::new('image')
        ->setBasePath('/uploads/images/')
        ->setLabel('Image')
        ->setSortable(false);


}

public function articlesByCategorieAction($categorieId, ArticleRepository $articleRepository)
{
    $articles = $articleRepository->findByCategorie($categorieId);

    return $this->render('article/index.html.twig', [
        'articles' => $articles,
]);
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





