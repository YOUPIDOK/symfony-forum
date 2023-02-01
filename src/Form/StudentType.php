<?php

namespace App\Form;

use App\Entity\Student;
use App\Enum\HighSchoolDegreeEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user', UserType::class, ['required_password' => $options['required_password']])
            ->add('degree', ChoiceType::class, [
                'label' => 'Classe',
                'required' => true,
                'choices' => HighSchoolDegreeEnum::getChoices()
            ])
            ->add('highSchool');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label' => false,
            'required_password' => false,
            'data_class' => Student::class,
        ]);
    }
}
