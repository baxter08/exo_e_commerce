<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstracCrudController;

use App\Repository\DevisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DevisRepository::class)]
class Devis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id ;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom ;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prenom ;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email ;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $telephone ;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description_travaux ;

    #[ORM\ManyToOne(inversedBy: 'devis')]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_devis = null;

    #[ORM\Column(nullable: true)]
    private array $panier_info = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getDescriptionTravaux(): ?string
    {
        return $this->description_travaux;
    }

    public function setDescriptionTravaux(?string $description_travaux): static
    {
        $this->description_travaux = $description_travaux;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getDateDevis(): ?\DateTimeInterface
    {
        return $this->date_devis;
    }

    public function setDateDevis(\DateTimeInterface $date_devis): static
    {
        $this->date_devis = $date_devis;

        return $this;
    }

    public function getPanierInfo(): array
    {
        return $this->panier_info;
    }

    public function setPanierInfo(?array $panier_info): static
    {
        $this->panier_info = $panier_info;

        return $this;
    }
}
