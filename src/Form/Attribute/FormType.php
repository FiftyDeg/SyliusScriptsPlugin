<?php

declare(strict_types=1);

namespace FiftyDeg\SyliusScriptsPlugin\Form\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class FormType
{
    public function __construct(
        private string $fieldType,
        private array $options = [],
    ) {
    }

    public function getFieldType(): string
    {
        return $this->fieldType;
    }

    /** @return array<array-key, mixed> */
    public function getOptions(): array
    {
        return $this->options;
    }
}
