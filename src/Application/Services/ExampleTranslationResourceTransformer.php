<?php

namespace Xing\ApiResourceBundle\Application\Services;

use Xing\ApiResourceBundle\Application\ApiResources\ExampleTranslationResource;
use Xing\ApiResourceBundle\Application\Configuration\FieldOptions\StringField;
use Xing\ApiResourceBundle\Application\Interfaces\ApiResource;
use Xing\ApiResourceBundle\Entity\ExampleTranslationEntity;

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
