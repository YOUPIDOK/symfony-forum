<?php

namespace App\Form;

use App\Entity\Student;
use App\Entity\Workshop;
use App\Entity\WorkshopReservation;
use App\Entity\WorkshopSector;
use App\Form\CustomType\EntitySelectChoicesType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkshopReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('student', EntitySelectChoicesType::class, [
                'label' => 'Étudiant',
                'class' => Student::class,
                'required' => false,
            ])
            ->add('workshop', EntitySelectChoicesType::class, [
                'label' => 'Atelier',
                'class' => Workshop::class,
                'choice_label' => function(Workshop $workshop) {
                    return $workshop->getName() .  ' (' . $workshop->getForum()->getName()  . ')';
                },
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WorkshopReservation::class,
        ]);
    }
}
