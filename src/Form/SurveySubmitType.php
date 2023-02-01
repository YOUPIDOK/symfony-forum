<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\Survey;
use App\Entity\SurveyAnswer;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SurveySubmitType extends AbstractType
{
    public function __construct(private Security $security) { }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var Survey $survey */
        $survey = $options['survey'];

        $answers = [];

        foreach ($survey->getSurveyQuestions() as $surveyQuestion) {
            $answers[] = (new SurveyAnswer())
                ->setSurveyQuestion($surveyQuestion)
                ->setStudent($this->security->getUser()->getStudent())
            ;
        }

        dd($answers);

        $builder->add('name');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'survey' => null,
        ]);
    }
}
