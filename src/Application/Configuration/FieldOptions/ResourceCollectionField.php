<?php

namespace Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions;

use Prescreen\ApiResourceBundle\Application\Enum\FieldType;

class ResourceCollectionField extends ResourceField
{
    public function __construct(
        string $resourceClass,
        bool $createIfNotExists = false,
        bool $required = false,
        protected readonly ?string $entityAdder = null,
        protected readonly ?string $entityRemover = null,
    ) {
        parent::__construct($resourceClass, $createIfNotExists, $required);
    }

    public function getEntityAdder(): ?string
    {
        return $this->entityAdder;
    }

    public function getEntityRemover(): ?string
    {
        return $this->entityRemover;
    }

    public function getType(): FieldType
    {
        return FieldType::RESOURCE_COLLECTION;
    }
}
