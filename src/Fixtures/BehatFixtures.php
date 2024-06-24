<?php

declare(strict_types=1);

namespace FiftyDeg\SyliusScriptsPlugin\Fixtures;

use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use FiftyDeg\SyliusScriptsPlugin\Entity\Script;
use FiftyDeg\SyliusScriptsPlugin\Repository\ScriptRepositoryInterface;
use Sylius\Bundle\FixturesBundle\Fixture\AbstractFixture;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

final class BehatFixtures extends AbstractFixture
{
    public function __construct(
        private string $env,
        private ScriptRepositoryInterface $scriptRepository,
        private ChannelRepositoryInterface $channelRepository,
    ) {
    }

    public function getName(): string
    {
        return 'fiftydeg_sylius_scripts_plugins';
    }

    public function load(array $options): void
    {
        if ($this->env !== 'test') {
            return;
        }

        /** @var array<string,array<string,string>> $scriptOptions */
        $scriptOptions = $options['scripts'];

        foreach ($scriptOptions as $scriptOption) {
            $script = new Script();

            $channel = $this->channelRepository->findOneByCode($scriptOption['channel']);

            if (null === $channel) {
                throw new Exception("{$scriptOption['channel']} does not exist.");
            }

            $channelsCollection = new ArrayCollection([$channel]);

            $script->setCurrentLocale($scriptOption['locale']);
            $script->setName($scriptOption['name']);
            $script->setTemplateEvent($scriptOption['template_event']);
            $script->setContent($scriptOption['content']);

            // @phpstan-ignore-next-line
            $script->setChannels($channelsCollection);

            $this->scriptRepository->add($script);
        }
    }

    protected function configureOptionsNode(ArrayNodeDefinition $optionsNode): void
    {
        // @phpstan-ignore-next-line
        $optionsNode
            ->children()
                ->arrayNode('scripts')
                    ->arrayPrototype()
                        ->children()
                                ->scalarNode('name')->isRequired()->end()
                                ->scalarNode('template_event')->isRequired()->end()
                                ->scalarNode('content')->isRequired()->end()
                                ->scalarNode('locale')->isRequired()->end()
                                ->scalarNode('channel')->isRequired()->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
