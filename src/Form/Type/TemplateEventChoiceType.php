<?php

declare(strict_types=1);

namespace FiftyDeg\SyliusScriptsPlugin\Form\Type;

use FiftyDeg\SyliusScriptsPlugin\ConfigLoader\ConfigLoaderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TemplateEventChoiceType extends AbstractType
{
    public function __construct(
        private ConfigLoaderInterface $configLoader,
    ) {
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'choices' => $this->getOptions(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getBlockPrefix()
    {
        return 'fiftydeg_scripts_template_events_';
    }

    /**
     * Returns a set of available options, of current option if form is in edit mode
     */
    private function getOptions(): array
    {
        $options = [];

        /** @var array<int, array<string,string>> $templateEvents */
        $templateEvents = $this->configLoader->getTemplateEvents();

        foreach ($templateEvents as $templateEvent) {
            $label = $templateEvent['label'];
            $value = $templateEvent['value'];

            $options[$label] = $value;
        }

        return $options;
    }
}
