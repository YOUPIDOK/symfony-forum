<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\Survey;
use App\Entity\SurveyAnswer;
use App\Repository\SurveyAnswerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SurveySubmitType extends AbstractType
{
    public function __construct(private Security $security, private SurveyAnswerRepository $surveyAnswerRepository) { }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var Survey $survey */
        $survey = $options['survey'];

        foreach ($survey->getSurveyQuestions() as $surveyQuestion) {
            $answer = $this->surveyAnswerRepository->findOneBy(['student' => $this->security->getUser()->getStudent(), 'surveyQuestion' => $surveyQuestion ]);

            if ($answer == null) {
                $answer = (new SurveyAnswer())
                    ->setSurveyQuestion($surveyQuestion)
                    ->setStudent($this->security->getUser()->getStudent())
                ;
            }

            $builder->add('surveyAnswer' . $surveyQuestion->getId(), SurveyAnswerSubmitType::class, [
                'data' => $answer,
                'question' => $surveyQuestion
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'survey' => null,
        ]);
    }
}
