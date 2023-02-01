<?php

namespace App\Form;

use App\Entity\Forum;
use App\Entity\JobActivity;
use App\Entity\Survey;
use App\Form\CustomType\EntitySelectChoicesType;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ForumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'nom',
                'required' => true,
            ])
            ->add('startAt', DateTimeType::class, [
                'label' => 'Date de début',
                'required' => true,
                'html5' => true,
                'widget' => 'single_text'
            ])
            ->add('endAt', DateTimeType::class, [
                'label' => 'Date de fin',
                'required' => true,
                'html5' => true,
                'widget' => 'single_text',
                'constraints' => [
                    new Callback([
                        'callback' => static function (?DateTime $value, ExecutionContextInterface $context) {
                            /** @var Forum $forum */
                            $forum = $context->getObject()->getParent()->getData();
                            if ($forum->getStartAt() != null && $forum->getEndAt() != null && $forum->getStartAt() >= $forum->getEndAt()) {
                                $context
                                    ->buildViolation('La date de début doit être supérieur à la date de fin.')
                                    ->atPath('startAt')
                                    ->addViolation();
                            }
                        }
                    ])
                ]
            ])
            ->add('survey', EntitySelectChoicesType::class, [
                'label' => 'Formulaire',
                'required' => false,
                'class' => Survey::class,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Forum::class,
        ]);
    }
}
