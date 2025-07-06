<?php

namespace App\Entity;

use App\Repository\RetraitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RetraitRepository::class)]
class Retrait
{
    #[ORM\Id]
    #[ORM\OneToOne(targetEntity: ArticleVendu::class, inversedBy: 'retrait')]
    #[ORM\JoinColumn(name: 'article_id', referencedColumnName: 'noArticle', nullable: false)]
    private ?ArticleVendu $article = null;

    #[ORM\Column(length: 255)]
    private ?string $rue = null;

    #[ORM\Column(length: 100)]
    private ?string $ville = null;

    #[ORM\Column(length: 10)]
    private ?string $codePostal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): static
    {
        $this->rue = $rue;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): static
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getArticle(): ?ArticleVendu
    {
        return $this->article;
    }

    public function setArticle(ArticleVendu $article): static
    {
        $this->article = $article;

        return $this;
    }
}
