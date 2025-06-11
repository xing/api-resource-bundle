<?php

namespace Prescreen\ApiResourceBundle\src\Application\Services;

use Prescreen\ApiResourceBundle\src\Application\ApiResources\ExampleResource;
use Prescreen\ApiResourceBundle\src\Application\ApiResources\ExampleTranslationResource;
use Prescreen\ApiResourceBundle\src\Application\Configuration\FieldOptions\BoolField;
use Prescreen\ApiResourceBundle\src\Application\Configuration\FieldOptions\ResourceCollectionField;
use Prescreen\ApiResourceBundle\src\Application\Configuration\FieldOptions\StringField;
use Prescreen\ApiResourceBundle\src\Application\Interfaces\ApiResource;
use Prescreen\ApiResourceBundle\src\Application\Services\PermissionValidators\CoolPermissionValidator;
use Prescreen\ApiResourceBundle\src\Entity\ExampleEntity;

class ExampleResourceTransformer extends ApiResourceTransformer
{
    private bool $userIsCool = true;

    public function getEntityClass(): string
    {
        return ExampleEntity::class;
    }

    public function getResourceClass(): string
    {
        return ExampleResource::class;
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
            'is_cool' => (new BoolField())->setPermissionValidator(new CoolPermissionValidator($this->userIsCool)),
            'translations' => new ResourceCollectionField(ExampleTranslationResource::class, true)
        ];
    }

    public function setUserIsCool(bool $userIsCool): ExampleResourceTransformer
    {
        $this->userIsCool = $userIsCool;
        return $this;
    }
}
