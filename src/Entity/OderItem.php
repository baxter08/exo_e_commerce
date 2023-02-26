<?php


namespace App\Entity;

use App\Entity\Article;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @ORM\Entity
 */
class OrderItem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="items")
     * @ORM\JoinColumn(nullable=false)
     */
    private $order;

    /**
     * @ORM\ManyToOne(targetEntity="Article", inversedBy="orderItems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): self
    {
        $this->order = $order;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getBestSellingArticles(EntityManagerInterface $entityManager, int $limit = 10): array
{
    $queryBuilder = $entityManager->createQueryBuilder();

    $queryBuilder
        ->select('articles', 'SUM(item.quantity) as totalQuantity')
        ->from(OrderItem::class, 'item')
        ->join('item.article', 'article')
        ->groupBy('article')
        ->orderBy('totalQuantity', 'DESC')
        ->setMaxResults($limit);

    $query = $queryBuilder->getQuery();

    return $query->getResult();
}


}
