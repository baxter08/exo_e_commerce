<?php

namespace App\Controller;

use App\Entity\Article;
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
    public function index(ArticleRepository $articleRepo, EntityManagerInterface $entityManager): Response
    {
        $articles = $articleRepo->findAll();

        $query = $entityManager->createQuery(
            'SELECT c
            FROM App\Entity\Commande c
            ORDER BY c.montant DESC'
        )->setMaxResults(10);

        $commandes = $query->getResult();

        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
            'articles' => $articles,
            'commandes' => $commandes
        ]);
    }
    #[Route('/article', name: 'article')]
    public function showArticlesByCategory(ArticleRepository $articleRepository): Response
    {
        $articlesDouche = $articleRepository->findBy(['sous_categorie' => 'La douche']);
        $articlesRemplacementBaignoire = $articleRepository->findBy(['sous_categorie' => 'Le remplacement de baignoire']);
    
        return $this->render('categorie/index.html.twig', [
            'articlesDouche' => $articlesDouche,
            'articlesRemplacementBaignoire' => $articlesRemplacementBaignoire,
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

    public function configureFields(string $imageName): iterable
    {
        yield ImageField::new('image')
            ->setBasePath('/uploads/images/')
            ->setLabel('Image')
            ->setSortable(false);
    }
    
}
