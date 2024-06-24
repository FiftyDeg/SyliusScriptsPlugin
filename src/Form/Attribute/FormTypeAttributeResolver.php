<?php

declare(strict_types=1);

namespace FiftyDeg\SyliusScriptsPlugin\Form\Attribute;

use ReflectionClass;
use Symfony\Component\Form\FormBuilderInterface;

class FormTypeAttributeResolver
{
    /** @param class-string $class */
    public function resolveFormFields(string $class, FormBuilderInterface $builder): void
    {
        $data = $this->extract($class);

        /** @var array $formField */
        foreach ($data as $formField) {
            /** @var string $formFieldName */
            $formFieldName = $formField['formFieldName'];

            /** @var string $formFieldType */
            $formFieldType = $formField['formFieldType'];

            /** @var array<string, mixed> $formFieldOptions */
            $formFieldOptions = $formField['formFieldOptions'];

            $builder->add(
                $formFieldName,
                $formFieldType,
                $formFieldOptions,
            );
        }
    }

    // TODO: evaluate a recursive solution, e.g. for translation
    protected function reflectProperties(array $data, ReflectionClass $reflectionClass): array
    {
        $reflectionProperties = $reflectionClass->getProperties();

        foreach ($reflectionProperties as $reflectionProperty) {
            $attributes = $reflectionProperty->getAttributes(FormType::class);

            foreach ($attributes as $attribute) {
                $formType = $attribute->newInstance();

                $data[] = [
                    'formFieldName' => $reflectionProperty->getName(),
                    'formFieldType' => $formType->getFieldType(),
                    'formFieldOptions' => $formType->getOptions(),
                ];
            }
        }

        return $data;
    }

    /** @param class-string $class */
    protected function extract(string $class): array
    {
        $data = [];
        $reflectionClass = new ReflectionClass($class);
        $data = $this->reflectProperties($data, $reflectionClass);

        return $data;
    }
}
