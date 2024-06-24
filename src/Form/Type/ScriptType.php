<?php

declare(strict_types=1);

namespace FiftyDeg\SyliusScriptsPlugin\Form\Type;

use FiftyDeg\SyliusScriptsPlugin\Entity\Script;
use FiftyDeg\SyliusScriptsPlugin\Form\Attribute\FormTypeAttributeResolver;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Symfony\Component\Form\FormBuilderInterface;

final class ScriptType extends AbstractResourceType
{
    public function __construct()
    {
        parent::__construct(
            Script::class,
            ['Default', 'sylius'],
        );
    }

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $formTypeResolver = new FormTypeAttributeResolver();
        $formTypeResolver->resolveFormFields(Script::class, $builder);

        $builder
            ->add(
                'translations',
                ResourceTranslationsType::class,
                [
                    'entry_type' => ScriptTranslationType::class,
                ],
            )
        ;
    }

    /**
     * @inheritDoc
     */
    public function getBlockPrefix(): string
    {
        return 'fiftydeg_sylius_scripts_script';
    }
}
