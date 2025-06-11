<?php

namespace Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions;

class ResourceCollectionField extends ResourceField
{
    const TYPE = 'resource_collection';

    public function __construct(
        string $resourceClass,
        bool $createIfNotExists = false,
        bool $required = false,
        protected readonly ?string $entityAdder = null,
        protected readonly ?string $entityRemover = null,
        bool $persist = true,
        string $uniqueIdentifierField = 'id',
    ) {
        parent::__construct(
            $resourceClass,
            $createIfNotExists,
            $required,
            self::TYPE,
            $persist,
            $uniqueIdentifierField,
        );
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
