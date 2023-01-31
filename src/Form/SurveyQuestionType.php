<?php

namespace App\Form;

use App\Entity\Survey;
use App\Entity\SurveyQuestion;
use App\Enum\SurveyQuestionTypeEnum;
use App\Enum\UserRoleEnum;
use App\Form\CustomType\EntitySelectChoicesType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SurveyQuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('question')
            ->add('type', ChoiceType::class, [
                'label' => 'Type de question',
                'required' => true,
                'choices' => SurveyQuestionTypeEnum::getChoices()
            ])
            ->add('survey', EntitySelectChoicesType::class, [
                'label' => 'Formulaire',
                'class' => Survey::class,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SurveyQuestion::class,
        ]);
    }
}
