<?php

namespace App\Form;

use App\Entity\JobActivity;
use App\Entity\Workshop;
use App\Form\CustomType\EntitySelectChoicesType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkshopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('startAt')
            ->add('endAt')
            ->add('sector')
            ->add('forum')
            ->add('speakers')
            ->add('resources')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Workshop::class,
        ]);
    }
}
