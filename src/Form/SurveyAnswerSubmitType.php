<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\SurveyAnswer;
use App\Entity\SurveyQuestion;
use App\Enum\SurveyQuestionTypeEnum;
use App\Repository\SurveyAnswerRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Range;

class SurveyAnswerSubmitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var SurveyQuestion $surveyQuestion */
        $surveyQuestion = $options['question'];

        if ($options['question']->getType() === SurveyQuestionTypeEnum::INTERVAL) {
            $builder->add('answer',  IntegerType::class, [
                'label' => $surveyQuestion->getQuestion(),
                'required' => true,
                'attr' => [
                    'min' => 0,
                    'max' => 5,
                ],
                'constraints' => [
                    new Range(min: 0, max: 5)
                ]
            ]);
        } elseif($options['question']->getType() === SurveyQuestionTypeEnum::CLOSE) {
            $builder->add('answer', ChoiceType::class, [
                'label' => $surveyQuestion->getQuestion(),
                'required' => true,
                'choices' => ['Oui' => 'Oui', 'Non' => 'Non'],
                'expanded' => true
            ]);
        } else {
            $builder->add('answer', TextType::class, [
                'label' => $surveyQuestion->getQuestion(),
                'required' => true
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'question' => null,
            'data_class' => SurveyAnswer::class,
            'label' => false
        ]);
    }
}
