<?php

namespace App\Entity;

// use Cocur\Slugify\Slugify;
use App\Entity\Image;
use App\Entity\Panier;
use App\Entity\Commande;
use App\Entity\Categorie;
use Cocur\Slugify\Slugify;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\DecimalType;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\ArticleRepository;
use phpDocumentor\Reflection\Types\Null_;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]

#[Assert\Expression("this.getId() === null or this.getId() === value",message:"L'ID de l'article ne peut pas être modifié.")]
 
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
    private ?string $description3 = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description4 = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $essentiel = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $sous_categorie = null;

    #[ORM\Column(type: "decimal", scale: 2)]
    private ?string $prix = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'Article', targetEntity: Image::class)]
    private Collection $images;

    #[ORM\OneToMany(mappedBy: 'Article', targetEntity: Panier::class, orphanRemoval: true)]
    private Collection $y;

    #[ORM\OneToMany(mappedBy: 'Article', targetEntity: Commande::class, orphanRemoval: true)]
    private Collection $commandes;

    
    #[ORM\ManyToMany(targetEntity:"Categorie", inversedBy:"articles")]
    #[ORM\JoinTable(name:"article_categorie")]
    private $categories;

     public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->y = new ArrayCollection();
        $this->commandes = new ArrayCollection();
    }

    public function prePersist()
    {
        $this->slug = (new Slugify())->slugify($this->id);
        return $this->slug;
    }

    // ...

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $encodedId;

    // ...

    public function setEncodedId(string $encodedId): self
    {
        $this->encodedId = $encodedId;

        return $this;
    }

    public function getEncodedId(): ?string
    {
        return $this->encodedId;
    }

    // ... 
    
    /**
     * @return Collection|Categorie[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
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

    public function getSlug($slug): string
    {
        return (new Slugify())->slugify($this->id);
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

    public function getDescription3(): ?string
    {
        return $this->description3;
    }

    public function setDescription3(string $description3): self
    {
        $this->description3 = $description3;

        return $this;
    }

    public function getDescription4(): ?string
    {
        return $this->description4;
    }

    public function setDescription4(string $description4): self
    {
        $this->description4 = $description4;

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

    public function getSous_categorie(): ?string
    {
       
        return $this->sous_categorie;
    }

    public function setSous_categorie(string $sous_categorie): self
    {
        $this->sous_categorie = $sous_categorie;
        

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

    /**
     * @return Collection<int, Categorie>
     */
    public function getCategorie(): Collection
    {
        return $this->categories;
    }

    public function addCategorie(Categorie $categorie): self
    {
        if (!$this->categories->contains($categorie)) {
            $this->categories->add($categorie);
        }

        return $this;
    }

    public function removeCategorie(Categorie $categorie): self
    {
        $this->categories->removeElement($categorie);

        return $this;
    }
}
