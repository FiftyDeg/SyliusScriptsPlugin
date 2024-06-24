<?php

declare(strict_types=1);

namespace FiftyDeg\SyliusScriptsPlugin\Entity;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;

interface ScriptInterface extends ResourceInterface, TranslatableInterface
{
    /**
     * @return Collection<int, ChannelInterface>
     */
    public function getChannels(): Collection;

    /**
     * @param Collection<int, ChannelInterface> $channels
     */
    public function setChannels(Collection $channels): self;

    public function getName(): ?string;

    public function setName(?string $name): self;

    public function getTemplateEvent(): ?string;

    public function setTemplateEvent(?string $templateEvent): self;

    public function getContent(): ?string;

    public function setContent(?string $content): self;
}
