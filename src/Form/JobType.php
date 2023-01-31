<?php

namespace App\Form;

use App\Entity\Job;
use App\Entity\JobActivity;
use App\Entity\JobSkill;
use App\Form\CustomType\EntitySelectChoicesType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'required' => true
            ])
             ->add('jobSkills', EntitySelectChoicesType::class, [
                 'label' => 'Compétences',
                 'class' => JobSkill::class,
                 'required' => false,
                 'multiple' => true,
             ])
            ->add('jobActivities', EntitySelectChoicesType::class, [
                'label' => 'Activités',
                'required' => false,
                'class' => JobActivity::class,
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Job::class,
        ]);
    }
}
