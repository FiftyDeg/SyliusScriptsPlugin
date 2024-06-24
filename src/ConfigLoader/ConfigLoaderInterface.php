<?php

declare(strict_types=1);

namespace FiftyDeg\SyliusScriptsPlugin\ConfigLoader;

interface ConfigLoaderInterface
{
    public function getTemplateEvents(): array;
}
