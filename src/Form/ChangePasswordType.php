<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('old_password', PasswordType::class,[
                'label' => 'Votre Mot de Passe Actuel',
                'mapped' => false,
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 8])
                ],
                'attr' => [
                    'placeholder' => 'Saisissez votre mot de passe'
            ]])
            ->add('new_password', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'Problème de confirmation de mot de passe',
            'label' => 'Votre Nouveau Mot de Passe',
            'required' => true,
            'mapped' => false,
            'first_options' => ['label' => 'Votre Nouveau Mot de Passe'],
            'second_options' => ['label' => 'Confirmez votre nouveau mot de passe'],
            'constraints' => [
                new NotBlank(),
                new Length(['min' => 8])
            ],
            'attr' => [
                'placeholder' => 'Saisissez votre mot de passe'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
