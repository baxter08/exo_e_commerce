<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ImageRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;



#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Article $Article = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
    }
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?ImageField 
    {
        return $this->image;
        
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->Article;
    }

    public function setArticle(?Article $Article): self
    {
        $this->Article = $Article;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function __toString()
    {
        return $this->image;
    }
    
}
