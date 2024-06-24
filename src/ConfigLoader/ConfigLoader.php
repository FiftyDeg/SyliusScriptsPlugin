<?php

declare(strict_types=1);

namespace FiftyDeg\SyliusScriptsPlugin\ConfigLoader;

use FiftyDeg\SyliusScriptsPlugin\DependencyInjection\FiftyDegSyliusScriptsExtension;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

final class ConfigLoader implements ConfigLoaderInterface
{
    public function __construct(
        private ParameterBag $parameterBag,
    ) {
    }

    public function getTemplateEvents(): array
    {
        /** @var array|null $templateEvents */
        $templateEvents = $this->getParam('template_events');

        return $templateEvents ?? [];
    }

    private function getParam(string $paramName): mixed
    {
        $safeParamName = FiftyDegSyliusScriptsExtension::CONTAINER_PARAM_PREFIX . $paramName;

        return $this->parameterBag->has($safeParamName)
            ? $this->parameterBag->get($safeParamName)
            : null;
    }
}
