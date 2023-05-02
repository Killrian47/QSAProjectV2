<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ExcelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('csv_file', FileType::class, [
                'constraints' => [
                    new File([
                        'extensions' => [
                            'csv',
                            'xlsx',
                        ],
                        'mimeTypesMessage' => 'Merci d\'envoyer un fichier .csv ou .xlsx',
                        'extensionsMessage' => 'Merci d\'envoyer un fichier .csv ou .xlsx',
                    ])
                ],
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control mt-1 '
                ],
                'label' => 'Ajouter un fichier excel avec les échantillons que vous voulez nous envoyer '
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn qsa-btn mt-2'
                ],
                'label' => 'Envoyer les échantillons'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
