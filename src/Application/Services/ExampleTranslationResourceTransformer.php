<?php

namespace Prescreen\ApiResourceBundle\src\Application\Services;

use Prescreen\ApiResourceBundle\src\Application\ApiResources\ExampleTranslationResource;
use Prescreen\ApiResourceBundle\src\Application\Configuration\FieldOptions\StringField;
use Prescreen\ApiResourceBundle\src\Application\Interfaces\ApiResource;
use Prescreen\ApiResourceBundle\src\Entity\ExampleTranslationEntity;

class ExampleTranslationResourceTransformer extends ApiResourceTransformer
{
    public function getEntityClass(): string
    {
        return ExampleTranslationEntity::class;
    }

    public function getResourceClass(): string
    {
        return ExampleTranslationResource::class;
    }

    protected function setResourceFields(object $entity, ApiResource $resource): void
    {
        // All fields will be filled by the resources fromEntity method.
        return;
    }

    protected function getWriteableFields(): array
    {
        return [
            'name' => new StringField(true),
            'locale' => new StringField(true)
        ];
    }
}
