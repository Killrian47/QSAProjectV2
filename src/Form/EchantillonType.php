<?php

namespace App\Form;

use App\Entity\Echantillon;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EchantillonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('productName')
            ->add('numberLot')
            ->add('fournisseur')
            ->add('conditionnement')
            ->add('tempProduct')
            ->add('tempEnceinte')
            ->add('dateOfManufacturing')
            ->add('DlcDluo')
            ->add('datePrelevement')
            ->add('entreprise')
            ->add('numberOrder')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Echantillon::class,
        ]);
    }
}