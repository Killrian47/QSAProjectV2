<?php

namespace App\Form;

use App\Entity\Echantillon;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class EchantillonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('productName', TextType::class, [
                'required' => false,
                'label' => 'Nom du produit :',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrer le nom du produit'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un nom pour votre produit'
                    ])
                ]
            ])
            ->add('numberLot', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrer le numéro de lot du produit'
                ],
                'required' => false,
                'label' => 'Numéro de lot :',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un numéro de lot',
                    ])
                ]
            ])
            ->add('fournisseur', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrer le fournisseur'
                ],
                'required' => false,
                'label' => 'Le fournisseur de votre produit :',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir le nom d\'un fournisseur'
                    ])
                ]
            ])
            ->add('conditionnement', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrer le conditionnement du produit'
                ],
                'required' => false,
                'label' => 'Le conditionnement de votre produit :',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir le type de conditionnement de votre produit ',
                    ])
                ]
            ])
            ->add('tempProduct', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrer la température du produit en degrés Celsius'
                ],
                'required' => false,
                'label' => 'La température de votre produit :',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir la température de votre produit'
                    ])
                ]
            ])
            ->add('tempEnceinte', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrer la température de l\'enceinte du produit en degrés Celsius'
                ],
                'required' => false,
                'label' => 'La température de l\'enceinte de votre produit :',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir la température de l\'enceinte de votre produit'
                    ])
                ]
            ])
            ->add('dateOfManufacturing', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Sélectionnez la date de création de votre produit :',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir la date de création de votre produit'
                    ])
                ],
                'required' => false,
            ])
            ->add('dlcDluo', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Sélectionnez la DLC ou le DLUO de votre produit :',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir la DLC ou le DLUO de votre produit'
                    ])
                ],
                'required' => false,
            ])
            ->add('datePrelevement', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Sélectionnez la date du prélèvement du produit :',
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn qsa-btn mt-3'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Echantillon::class,
        ]);
    }
}
