<?php

namespace Prescreen\ApiResourceBundle\Application\Services;

use Prescreen\ApiResourceBundle\Application\ApiResources\ExampleTranslationResource;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\StringField;
use Prescreen\ApiResourceBundle\Application\Interfaces\ApiResource;
use Prescreen\ApiResourceBundle\Entity\ExampleTranslationEntity;

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
