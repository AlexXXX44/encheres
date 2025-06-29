<?php

namespace App\Form;

use App\Entity\ArticleVendu;
use App\Entity\Categorie;
use App\Entity\Retrait;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleVenduTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomArticle')
            ->add('description')
            ->add('etatVente')
            ->add('dateDebutEncheres', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Début des enchères'
            ])
            ->add('dateFinEncheres', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Fin des enchères'
            ])
            ->add('prixInitial', IntegerType::class, [
                'label' => 'Prix de départ'
            ])
            ->add('prixVente', IntegerType::class, [
                'required' => false,
                'label' => 'Prix de vente final'
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'libelle',
                'placeholder' => '--Choisir une catégorie--'
            ])
            ->add('utilisateur', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'pseudo',
                'placeholder' => '--Sélectionner un  vendeur--'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ArticleVendu::class,
        ]);
    }
}
