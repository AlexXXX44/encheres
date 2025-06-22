<?php

namespace App\Service;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;

class UtilisateurService
{
    private UtilisateurRepository $utilisateurRepository;
    public function __construct(UtilisateurRepository $utilisateurRepository,
                                EntityManagerInterface $entityManager,
                                UserPasswordHasherInterface $passwordHasher,
                                Security $security){
        $this->utilisateurRepository = $utilisateurRepository;
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
        $this->security = $security;
    }

    public function getUtilisateur(){
    }

    public function getUtilisateurById(){
    }

    public function getUtilisateurByPseudo(){
    }

    public function getUtilisateurByEmail(){
    }

    public function getUtilisateurByTelephone(){
    }

    public function getUtilisateurByRue(){}

    public function getUtilisateurByVille(){}

    public function getUtilisateurByCodePostal(){}

    public function getUtilisateurByCredit(){}

    public function getUtilisateurByAdministrateur(){}
}
