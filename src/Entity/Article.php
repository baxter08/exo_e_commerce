<?php

namespace App\Entity;

use App\Entity\Image;
use App\Entity\Panier;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\DecimalType;
use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Commande;
use phpDocumentor\Reflection\Types\Null_;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description2 = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $essentiel = null;

    #[ORM\Column(type: "decimal", scale: 2)]
    private ?string $prix = null;

    #[ORM\OneToMany(mappedBy: 'Article', targetEntity: Image::class)]
    private Collection $images;

    #[ORM\OneToMany(mappedBy: 'Article', targetEntity: Panier::class, orphanRemoval: true)]
    private Collection $y;

    #[ORM\OneToMany(mappedBy: 'Article', targetEntity: Commande::class, orphanRemoval: true)]
    private Collection $commandes;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->y = new ArrayCollection();
        $this->commandes = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription2(): ?string
    {
        return $this->description2;
    }

    public function setDescription2(string $description2): self
    {
        $this->description2 = $description2;

        return $this;
    }


    public function getEssentiel(): ?string
    {
        return $this->essentiel;
    }

    public function setEssentiel(string $essentiel): self
    {
        $this->essentiel = $essentiel;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {

        return $this->images;
    }


    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setArticle($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getArticle() === $this) {
                $image->setArticle(null);
            }
        }

        return $this;
    }



    /**
     * @return Collection<int, Panier>
     */
    public function getY(): Collection
    {
        return $this->y;
    }

    public function addY(Panier $y): self
    {
        if (!$this->y->contains($y)) {
            $this->y->add($y);
            $y->setArticle($this);
        }

        return $this;
    }

    public function removeY(Panier $y): self
    {
        if ($this->y->removeElement($y)) {
            // set the owning side to null (unless already changed)
            if ($y->getArticle() === $this) {
                $y->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->setArticle($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getArticle() === $this) {
                $commande->setArticle(null);
            }
        }

        return $this;
    }
}
