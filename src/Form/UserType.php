<?php

namespace App\Form;

use App\Entity\User;
use App\Validator\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Unique;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'E-mail',
                'required' => true,
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'required' => true
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'required' => true
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone',
                'required' => true,
                'constraints' => [
                    new Length(['max' => 13])
                ]
            ])
        ;

        $builder->add('plainPassword', PasswordType::class, [
            'label' =>'mot de passe',
            'required' => $options['required_password'],
            'mapped' => false,
            'constraints' => [
                new Length(['min' => 8])
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'label' => false,
            'required_password' => false,
            'constraints' => [
                new UniqueEntity('email')
            ]
        ]);
    }
}
