<?php

namespace Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions;

class ResourceField extends FieldOptions
{
    const TYPE = 'resource';

    public function __construct(
        protected readonly string $resourceClass,
        protected readonly bool $createIfNotExists = false,
        bool $required = false,
        string $type = self::TYPE,
        private readonly bool $persist = true,
        private readonly string $uniqueIdentifierField = 'id',
    ) {
        parent::__construct($type, $required);
    }

    public function getResourceClass(): string
    {
        return $this->resourceClass;
    }

    public function isCreateIfNotExists(): bool
    {
        return $this->createIfNotExists;
    }

    public function isPersist(): bool
    {
        return $this->persist;
    }

    public function getUniqueIdentifierField(): string
    {
        return $this->uniqueIdentifierField;
    }
}
