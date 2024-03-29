<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    

    public function save(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);
        
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function countArticlesByArticle(): array
{
    return $this->createQueryBuilder('a')
        ->leftJoin('a.lignesCommandes', 'lc')
        ->select('a.id, a.designation, a.prixUnitaire, COUNT(lc.id) as nbArticles')
        ->groupBy('a.id')
        ->orderBy('nbArticles', 'DESC')
        ->getQuery()
        ->getResult();
}
   /**
    * @return Article[] Returns an array of Article objects
   */
    public function search($mots)
    {
        return $this->createQueryBuilder('a')    
           ->andWhere('a.nom LIKE :val')
            ->setParameter('val', "%{$mots}%")
           ->orderBy('a.id', 'ASC')
           ->setMaxResults(3)
           ->getQuery()
           ->getResult()
       ;
  }

  

//    public function findOneBySomeField($value): ?Article
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
