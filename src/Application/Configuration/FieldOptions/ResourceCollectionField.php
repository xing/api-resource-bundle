<?php

namespace Prescreen\ApiResourceBundle\src\Application\Configuration\FieldOptions;

class ResourceCollectionField extends ResourceField
{
    const string TYPE = 'resource_collection';

    public function __construct(
        string $resourceClass,
        bool $createIfNotExists = false,
        bool $required = false,
        protected readonly ?string $entityAdder = null,
        protected readonly ?string $entityRemover = null,
    ) {
        parent::__construct($resourceClass, $createIfNotExists, $required, self::TYPE);
    }

    public function getEntityAdder(): ?string
    {
        return $this->entityAdder;
    }

    public function getEntityRemover(): ?string
    {
        return $this->entityRemover;
    }
}
