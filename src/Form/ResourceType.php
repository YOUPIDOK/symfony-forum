<?php

namespace App\Form;

use App\Entity\Resource;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ResourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var Resource $resource */
        $resource = $options['data'];

        $builder->add('name', TextType::class, [
            'label' => 'Nom',
            'required' => true,
        ]);

        if ($resource->isFile()) {
            $builder->add('file', VichFileType::class, [
                'label' => 'Fichier',
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
                'constraints' => [
                    new Callback([
                        'callback' => static function (?string $value, ExecutionContextInterface $context) {
                            /** @var Resource $ressource */
                            $ressource = $context->getObject()->getParent()->getData();
                            if (empty($ressource->getFilename()) && $ressource->getFile() === null) {
                                $context
                                    ->buildViolation('Aucun fichier déposé.')
                                    ->atPath('file')
                                    ->addViolation();
                            }
                        },
                    ]),
                ]
            ]);
        } else {
            $builder->add('url', TextType::class, [
                'label' => 'Nom',
                'required' => true,
                'constraints' => [
                    new NotNull()
                ]
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Resource::class,
        ]);
    }
}
