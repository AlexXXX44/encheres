<?php
// src/Repository/UtilisateurRepository.php
namespace App\Repository;

use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UtilisateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateur::class);
    }

    public function findByPseudo(string $pseudo): ?Utilisateur
    {
        return $this->findOneBy(['pseudo' => $pseudo]);
    }

    public function existsByPseudo(string $pseudo): bool
    {
        return $this->count(['pseudo' => $pseudo]) > 0;
    }

    public function existsByEmail(string $email): bool
    {
        return $this->count(['email' => $email]) > 0;
    }
}
