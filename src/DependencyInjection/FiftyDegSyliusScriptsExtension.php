<?php

declare(strict_types=1);

namespace FiftyDeg\SyliusScriptsPlugin\DependencyInjection;

use Error;
use Sylius\Bundle\CoreBundle\DependencyInjection\PrependDoctrineMigrationsTrait;
use Sylius\Bundle\ResourceBundle\DependencyInjection\Extension\AbstractResourceExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class FiftyDegSyliusScriptsExtension extends AbstractResourceExtension implements PrependExtensionInterface
{
    use PrependDoctrineMigrationsTrait;

    public const CONTAINER_PARAM_PREFIX = '_fd_scripts.';

    /** @psalm-suppress UnusedVariable */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = $this->getConfiguration([], $container);

        if (null === $configuration) {
            return;
        }

        /** @var array<array<string,array<string,array<string,string>>>> $processedConfig */
        $processedConfig = $this->processConfiguration($configuration, $configs);

        $fileLocator = new FileLocator(__DIR__ . '/../Resources/config');
        $loader = new YamlFileLoader($container, $fileLocator);
        $loader->load('bundle.yaml');

        foreach ($processedConfig as $key => $param) {
            $container->setParameter(self::CONTAINER_PARAM_PREFIX . $key, $param);
        }
    }

    public function prepend(ContainerBuilder $container): void
    {
        $this->prependDoctrineMigrations($container);
        $this->prependSyliusUi($container);
    }

    protected function getMigrationsNamespace(): string
    {
        return 'DoctrineMigrations';
    }

    protected function getMigrationsDirectory(): string
    {
        return '@FiftyDegSyliusScriptsPlugin/Migrations';
    }

    protected function getNamespacesOfMigrationsExecutedBefore(): array
    {
        return [
            'Sylius\Bundle\CoreBundle\Migrations',
        ];
    }

    protected function prependSyliusUi(ContainerBuilder $container): void
    {
        try {
            /** @var array<array<string,array<string,array<string,string>>>> $extensionConfig */
            $extensionConfig = $container->getExtensionConfig($this->getAlias());

            $templateEvents = $extensionConfig[0]['template_events'];

            $events = [];

            foreach ($templateEvents as $templateEvent) {
                $templateEventName = $templateEvent['value'];

                $blockHash = md5(serialize($templateEvent));

                $events[$templateEventName] = [
                    'blocks' => [
                        'fiftydeg_script_' . $blockHash => [
                            'template' => '@FiftyDegSyliusScriptsPlugin/Shop/Scripts/_renderScript.html.twig',
                            'priority' => \PHP_INT_MAX,
                            'context' => [
                                'template_event' => $templateEventName,
                            ],
                        ],
                    ],
                ];
            }

            $container->prependExtensionConfig('sylius_ui', [
                'events' => $events,
            ]);
        } catch (Error $error) {
            // Nothing to do here
        }
    }
}
