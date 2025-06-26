<?php

namespace Xing\ApiResourceBundle\Application\Services;

use Xing\ApiResourceBundle\Application\ApiResources\ExampleResource;
use Xing\ApiResourceBundle\Application\ApiResources\ExampleTranslationResource;
use Xing\ApiResourceBundle\Application\Configuration\FieldOptions\BoolField;
use Xing\ApiResourceBundle\Application\Configuration\FieldOptions\ResourceCollectionField;
use Xing\ApiResourceBundle\Application\Configuration\FieldOptions\StringField;
use Xing\ApiResourceBundle\Application\Interfaces\ApiResource;
use Xing\ApiResourceBundle\Application\Services\PermissionValidators\CoolPermissionValidator;
use Xing\ApiResourceBundle\Entity\ExampleEntity;

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
