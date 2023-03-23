<?php

namespace App\Form;

use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Adresse email de l\'entreprise : ',
                'disabled' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('name', TextType::class, [
                'disabled' => true,
                'label' => 'Nom de l\'entreprise :',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('old_password', PasswordType::class, [
                'mapped' => false,
                'label' => 'Mot de passe actuel',
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre mot de passe actuel',
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci d\'entrer votre ancien mot de passe',
                    ]),
                ]
            ])
            ->add('new_password', RepeatedType::class, [
//                'required' => false,
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mot de passe doivent être identiques',
                'first_name' => 'first',
                'second_name' => 'second',
                'first_options' => [

                    'label' => 'Votre nouveau mot de passe :',
                    'attr' => [
                        'class' => 'd-flex form-control',
                        'placeholder' => 'Veuillez saisir votre nouveau mot de passe'
                    ],

                ],
                'second_options' => [
                    'label' => 'Confirmer votre nouveau mot de passe :',
                    'label_attr' => [
                        'class' => 'mt-1',
                    ],
                    'attr' => [
                        'class' => 'form-control',
                        'placeholder' => 'Confirmer votre nouveau mot de passe'
                    ],
                ],
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci d\'entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit faire au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Mettre à jour',
                'attr' => [
                    'class' => 'btn qsa-btn mt-3'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
