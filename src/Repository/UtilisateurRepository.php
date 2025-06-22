<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Utilisateur>
 */
class UtilisateurRepository extends ServiceEntityRepository
{
    private mixed $utilisateurRepository;
    private mixed $em;
    private mixed $security;
    private mixed $passwordHasher;

    public function __construct(ManagerRegistry $registry, $utilisateurRepository, $security)
    {
        parent::__construct($registry, Utilisateur::class);
        $this->utilisateurRepository = $utilisateurRepository;
        $this->em = $registry->getManager();
        $this->security = $security;
        $this->passwordHasher = $security->getUserPasswordHasher();
    }

    //    /**
    //     * @return Utilisateur[] Returns an array of Utilisateur objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Utilisateur
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findOneByEmail($email)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery();
    }

    public function findOneByPseudo($pseudo): ?Utilisateur
    {
        return $this->utilisateurRepository->findOneBy(['pseudo' => $pseudo]);
    }

    public function ajouter(Utilisateur $utilisateur, string $confirmPassword): void
    {
//            $utilisateur->setMotDePasse(password_hash($confirmPassword, PASSWORD_DEFAULT));
//            $this->utilisateurRepository->save($utilisateur);
        $this->validateConfirmMdp($confirmPassword);
        $this->validatePseudo($utilisateur);
        $this->validateEmail($utilisateur);

        $utilisateur->setCredit(1000);
        $utilisateur->setAdministrateur(false);

        $hashedPassword = password_hash($utilisateur->getMotDePasse(), PASSWORD_DEFAULT);
        $utilisateur->setMotDePasse($hashedPassword);

        $this->em->persist($utilisateur);
        $this->em->flush();
    }

    public function modifier(Utilisateur $utilisateur, ?string $nouveauMotDePasse, string $confirmPassword): void
    {
        $utilisateur = $this->security->getUser();

        if (!empty($utilisateur->getMotDePasse())) {
            $this->validateMdp($utilisateur->getMotDePasse(), $utilisateur);
        }

        if ($utilisateur->getMotDePasse() === $nouveauMotDePasse || empty($nouveauMotDePasse)) {
            $utilisateur->setMotDePasse($utilisateur->getMotDePasse());
        } else {
            $hashedPassword = $this->passwordHasher->hashPassword($utilisateur, $nouveauMotDePasse);
            $utilisateur->setMotDePasse($hashedPassword);
        }

        $this->validateConfirmMdp($confirmPassword);

        if ($utilisateur->getPseudo() !== $utilisateur->getPseudo()) {
            $this->validatePseudo($utilisateur);
        }

        if ($utilisateur->getEmail() !== $utilisateur->getEmail()) {
            $this->validateEmail($utilisateur);
        }

        $this->em->persist($utilisateur);
        $this->em->flush();
    }

    public function supprimer(string $pseudo): void
    {
        $utilisateur = $this->findOneByPseudo($pseudo);
        if ($utilisateur) {
            $this->em->remove($utilisateur);
            $this->em->flush();
        }
    }

    private function validatePseudo(Utilisateur $utilisateur): void
    {
        if ($this->utilisateurRepository->count(['pseudo' => $utilisateur->getPseudo()]) > 0) {
            throw new MetierException('Pseudo existant');
        }
    }

    private function validateEmail(Utilisateur $utilisateur): void
    {
        if ($this->utilisateurRepository->count(['email' => $utilisateur->getEmail()]) > 0) {
            throw new MetierException('Email existant');
        }
    }

    private function validateMdp(string $oldPassword, Utilisateur $utilisateur): void
    {
        if (!$this->passwordHasher->isPasswordValid($utilisateur, $oldPassword)) {
            throw new ("Le mot de passe est incorrecte.");
        }
    }

    private function validateConfirmMdp(string $confirmPassword): void
    {
        if(empty($confirmPassword)){
            throw new ("La confirmation du mot de passe est incorrecte.");
        }
    }
}
