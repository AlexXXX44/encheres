<?php

namespace App\Entity;

use App\Repository\ArticleVenduRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleVenduRepository::class)]
class ArticleVendu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $noArticle = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

    #[ORM\OneToOne(targetEntity: Retrait::class, mappedBy: 'article', cascade: ['persist', 'remove'])]
    private ?Retrait $retrait = null;

    /**
     * @var Collection<int, Enchere>
     */
    #[ORM\OneToMany(targetEntity: Enchere::class, mappedBy: 'article', cascade: ['remove'])]
    private Collection $encheres;

    #[ORM\Column(length: 255)]
    private ?string $nomArticle = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 20)]
    private ?string $etatVente = null;

    #[ORM\Column]
    private ?\DateTime $dateDebutEncheres = null;

    #[ORM\Column]
    private ?\DateTime $dateFinEncheres = null;

    #[ORM\Column]
    private ?int $prixInitial = null;

    #[ORM\Column(nullable: true)]
    private ?int $prixVente = null;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $utilisateur = null;

    public function __construct()
    {
        $this->encheres = new ArrayCollection();
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getRetrait(): ?Retrait
    {
        return $this->retrait;
    }

    public function setRetrait(?Retrait $retrait): static
    {
        $this->retrait = $retrait;

        return $this;
    }

    /**
     * @return Collection<int, Enchere>
     */
    public function getEncheres(): Collection
    {
        return $this->encheres;
    }

    public function addEnchere(Enchere $enchere): static
    {
        if (!$this->encheres->contains($enchere)) {
            $this->encheres->add($enchere);
            $enchere->setArticle($this);
        }

        return $this;
    }

    public function removeEnchere(Enchere $enchere): static
    {
        if ($this->encheres->removeElement($enchere)) {
            // set the owning side to null (unless already changed)
            if ($enchere->getArticle() === $this) {
                $enchere->setArticle(null);
            }
        }

        return $this;
    }

    public function getNoArticle(): ?int
    {
        return $this->noArticle;
    }

    public function setNoArticle(int $noArticle): static
    {
        $this->noArticle = $noArticle;

        return $this;
    }

    public function getNomArticle(): ?string
    {
        return $this->nomArticle;
    }

    public function setNomArticle(string $nomArticle): static
    {
        $this->nomArticle = $nomArticle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getEtatVente(): ?string
    {
        return $this->etatVente;
    }

    public function setEtatVente(string $etatVente): static
    {
        $this->etatVente = $etatVente;

        return $this;
    }

    public function getDateDebutEncheres(): ?\DateTime
    {
        return $this->dateDebutEncheres;
    }

    public function setDateDebutEncheres(\DateTime $dateDebutEncheres): static
    {
        $this->dateDebutEncheres = $dateDebutEncheres;

        return $this;
    }

    public function getDateFinEncheres(): ?\DateTime
    {
        return $this->dateFinEncheres;
    }

    public function setDateFinEncheres(\DateTime $dateFinEncheres): static
    {
        $this->dateFinEncheres = $dateFinEncheres;

        return $this;
    }

    public function getPrixInitial(): ?int
    {
        return $this->prixInitial;
    }

    public function setPrixInitial(int $prixInitial): static
    {
        $this->prixInitial = $prixInitial;

        return $this;
    }

    public function getPrixVente(): ?int
    {
        return $this->prixVente;
    }

    public function setPrixVente(?int $prixVente): static
    {
        $this->prixVente = $prixVente;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
}
