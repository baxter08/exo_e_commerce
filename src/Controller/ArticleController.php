<?php

namespace App\Controller;


use App\Entity\Article;
use App\Entity\Categorie;
use App\Util\SlugifyUtil;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    public function index(ArticleRepository $articleRepo, EntityManagerInterface $entityManager, CategorieRepository $categorieRepo): Response
    {
        $articles = $articleRepo->findAll();

        foreach ($articles as $article) {
            $article->setEncodedId(base64_encode($article->getId()));
        }

        $query = $entityManager->createQuery(
            'SELECT c
            FROM App\Entity\Commande c
            ORDER BY c.montant DESC'
        )->setMaxResults(10);

        $commandes = $query->getResult();
        $categorie = $categorieRepo->findAll();
            
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
            'articles' => $articles,
            'commandes' => $commandes,
            'categorie' => $categorie,
            'js_file' => 'assets/index.js', // Chemin vers votre fichier JavaScript
        ]);
    }


    // #[Route('/article/{slug}-{id<[0-9]+>}', name: 'app_article', requirements: ['slug' => '[a-z0-9\-_]*'])]
    // public function show(ArticleRepository $articleRepo, string $slug, int $id): Response
    // {
    //     $article = $articleRepo->find($id);

    //     if (!$article || $article->getSlug($id) !== $slug) {
    //         throw new NotFoundHttpException('Article not found');
    //     }

    //     return $this->render('article/show.html.twig', [
    //         'article' => $article,
    //     ]);
    // }

    #[Route('/article/{slug}-{id<[0-9]+>}', name: 'app_detail_articles_show', requirements: ["slug" => "[a-z0-9\-]*"])]
    public function show(Article $article, string $slug, int $id): Response
    {
        $slugFromId = SlugifyUtil::slugify($id);
        
        if (!$article || $slugFromId !== $slug) {
            throw new NotFoundHttpException('Article not found');
        }
    
        if ($slugFromId !== $slug) {
            return $this->redirectToRoute('app_detail_article_show', [
                'id' => $article->getId(),
                'slug' => $slugFromId,
            ], 301);
        }
    
        return $this->render('article/show.html.twig', [
            'article' => $article,
            'id' => $id,
            'js_file' => 'assets/index.js', // Chemin vers votre fichier JavaScript
        ]);
    }

    



    //     #[Route('/article', name: 'article')]
    //     public function showArticlesByCategory(CategorieRepository $categorieRepo): Response
    //     {
    //         $categorieId = 1; // Remplacez 1 par l'ID de la catégorie souhaitée
    //         $categorie = $categorieRepo->find($categorieId);

    //         if (!$categorie) {
    //             throw $this->createNotFoundException('La catégorie spécifiée n\'existe pas.');
    //         }

    //         $articles = $categorie->getArticles();
    // // dd($articles);
    //         return $this->render('article/index.html.twig', [
    //             'articles' => $articles,
    //             'categorie' => $categorie,
    //         ]);


    // }

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
    public function search(ArticleRepository $articleRepo, Request $request): Response
    {
        if ($request) {
            $articles = $articleRepo->search($request->get('mots'));
        } else {
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
}
