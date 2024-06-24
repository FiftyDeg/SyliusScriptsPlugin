<?php

declare(strict_types=1);

namespace FiftyDeg\SyliusScriptsPlugin\Form\Type;

use FiftyDeg\SyliusScriptsPlugin\Entity\ScriptTranslation;
use FiftyDeg\SyliusScriptsPlugin\Form\Attribute\FormTypeAttributeResolver;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\FormBuilderInterface;

final class ScriptTranslationType extends AbstractResourceType
{
    public function __construct()
    {
        parent::__construct(
            ScriptTranslation::class,
            ['Default', 'sylius'],
        );
    }

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $formTypeResolver = new FormTypeAttributeResolver();
        $formTypeResolver->resolveFormFields(ScriptTranslation::class, $builder);
    }

    /**
     * @inheritDoc
     */
    public function getBlockPrefix(): string
    {
        return 'fiftydeg_sylius_scripts_script_translation';
    }
}
