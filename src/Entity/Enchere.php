<?php

namespace App\Entity;

use App\Repository\EnchereRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnchereRepository::class)]
class Enchere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $dateEnchere = null;

    #[ORM\Column]
    private ?int $montantEnchere = null;

    #[ORM\ManyToOne(inversedBy: 'encheres')]
    #[ORM\JoinColumn(nullable: 'false')]
    private ?Utilisateur $utilisateur;

    #[ORM\ManyToOne(inversedBy: 'encheres')]
    #[ORM\JoinColumn(name: "article_id", referencedColumnName: "noArticle", nullable: false)]
    private ?ArticleVendu $article;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEnchere(): ?\DateTime
    {
        return $this->dateEnchere;
    }

    public function setDateEnchere(\DateTime $dateEnchere): static
    {
        $this->dateEnchere = $dateEnchere;

        return $this;
    }

    public function getMontantEnchere(): ?int
    {
        return $this->montantEnchere;
    }

    public function setMontantEnchere(int $montantEnchere): static
    {
        $this->montantEnchere = $montantEnchere;

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

    public function getArticle(): ?ArticleVendu
    {
        return $this->article;
    }

    public function setArticle(?ArticleVendu $article): static
    {
        $this->article = $article;

        return $this;
    }
}
