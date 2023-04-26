<?php
// src/Entity/OrderItem.php

namespace App\Entity;
use App\Entity\Article;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class OrderItem
{
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
     
    private $id;

    
     #[ORM\Column(type:'integer')]
    
    private $quantity;

    
     #[ORM\ManyToOne(targetEntity: 'App\Entity\Article', inversedBy: 'orderItem')]
     #[ORM\JoinColumn(nullable:false)]
     
    private $article;

    // ...

    public function getId(): ?int
    {
        return $this->id;
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

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }
}
