<?php

namespace App\Form;

use App\Entity\JobActivity;
use App\Entity\Forum;
use App\Entity\Speaker;
use App\Entity\Workshop;
use App\Form\CustomType\EntitySelectChoicesType;
use App\Entity\WorkshopSector;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class WorkshopType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
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
                            /** @var Workshop $workshop */
                            $workshop = $context->getObject()->getParent()->getData();
                            if ($workshop->getStartAt() != null && $workshop->getEndAt() != null && $workshop->getStartAt() >= $workshop->getEndAt()) {
                                $context
                                    ->buildViolation('La date de début doit être supérieur à la date de fin.')
                                    ->atPath('startAt')
                                    ->addViolation();
                            }
                        }
                    ])
                ]
            ])
            ->add('sector', EntitySelectChoicesType::class, [
                'label' => 'Secteur',
                'class' => WorkshopSector::class,
                'required' => false,
            ])
            ->add('forum', EntitySelectChoicesType::class, [
                'label' => 'Forum',
                'class' => Forum::class,
                'required' => false,
            ])
            ->add('speakers', EntitySelectChoicesType::class, [
                'label' => 'Interventants',
                'class' => Speaker::class,
                'required' => false,
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Workshop::class,
        ]);
    }
}
