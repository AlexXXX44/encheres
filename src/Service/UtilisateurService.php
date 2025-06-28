<?php

namespace App\Service;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;

class UtilisateurService
{
    private UtilisateurRepository $utilisateurRepository;

    public function __construct(UtilisateurRepository       $utilisateurRepository,
                                EntityManagerInterface      $entityManager,
                                UserPasswordHasherInterface $passwordHasher)
    {
        $this->utilisateurRepository = $utilisateurRepository;
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    public function findByPseudo($pseudo): ?Utilisateur
    {
        return $this->utilisateurRepository->existsByPseudo($pseudo);
    }

    public function getUtilisateur($id)
    {
        return $this->utilisateurRepository->find($id);
    }

    public function ajouter(Utilisateur $utilisateur, string $confirmPassword): void
    {
        if (empty($confirmPassword)) {
            throw new \InvalidArgumentException("La confirmation du mot de passe est incorrecte.");
        }

        if ($this->utilisateurRepository->existsByPseudo($utilisateur->getPseudo())) {
            throw new \RuntimeException("Pseudo existant");
        }

        if ($this->utilisateurRepository->existsByEmail($utilisateur->getEmail())) {
            throw new \RuntimeException("Email existant");
        }

        $utilisateur->setCredit(1000);
        $utilisateur->setAdministrateur(false);
        $hashedPassword = $this->passwordHasher->hashPassword($utilisateur, $utilisateur->getMotDePasse());;
        $utilisateur->setMotDePasse($hashedPassword);

        $this->entityManager->persist($utilisateur);
        $this->entityManager->flush();
    }

    public function modifier(Utilisateur $utilisateur, UserInterface $user, string $confirmPassword): void
    {
        $dbUser = $this->utilisateurRepository->findOneByPseudo($user->getId());

        if ($this->passwordHasher->isPasswordValid($dbUser, $user->getMotDePasse())) {
            throw new \RuntimeException("Mot de passe incorrect");
        }

        if (!empty($nouvMotDePasse)) {
            $hashedPassword = $this->passwordHasher->hashPassword($utilisateur, $nouvMotDePasse);
            $utilisateur->setMotDePasse($hashedPassword);
        }

        if ($dbUser->getPseudo() !== $user->getPseudo() && $this->utilisateurRepository->existsByPseudo($user->getPseudo())) {
            throw new \RuntimeException("Pseudo existant");
        }

        if ($dbUser->getEmail() !== $user->getEmail() && $this->utilisateurRepository->existsByEmail($user->getEmail())) {
            throw new \RuntimeException("Email existant");
        }

        if(empty($confirmPassword)){
            throw new \RuntimeException("La confirmation du mot de passe est incorrecte.");
        }

        $this->entityManager->persist($utilisateur);
        $this->entityManager->flush();
    }

    public function supprimer(string $pseudo): void
    {
        $utilisateur = $this->utilisateurRepository->findOneByPseudo($pseudo);
        if ($utilisateur) {
            $this->entityManager->remove($utilisateur);
            $this->entityManager->flush();
        }
    }
}
