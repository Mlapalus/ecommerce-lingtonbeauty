<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Votre Prénom',
                'attr' => [
                    'placeholder' => 'Saisissez votre prénom'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre Nom',
                'attr' => [
                    'placeholder' => 'Saisissez votre nom'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre Email',
                'attr' => [
                    'placeholder' => "Saisissez votre email"
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Votre Mot de Passe',
                'attr' => [
                    'placeholder' => 'Saisissez votre mot de passe'
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Votre Mot de Passe',
                'attr' => [
                    'placeholder' => 'Saisissez votre mot de passe'
                ]
            ])
            ->add('password_confirm', PasswordType::class, [
                'label' => 'Confirmez votre Mot de Passe',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Ressaisissez votre mot de passe'
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
