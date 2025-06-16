<?php

namespace Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions;

use Prescreen\ApiResourceBundle\Application\Enum\FieldType;

class ResourceField extends FieldOptions
{
    public function __construct(
        protected readonly string $resourceClass,
        protected readonly bool $createIfNotExists = false,
        bool $required = false,
        protected readonly bool $persist = true,
        protected readonly string $uniqueIdentifierField = 'id',
        protected readonly bool $allowNullIfIdentifierIsPresent = false,
        protected readonly bool $removeOldValueOnNull = false,
    ) {
        parent::__construct($required);
    }

    public function getResourceClass(): string
    {
        return $this->resourceClass;
    }

    public function isCreateIfNotExists(): bool
    {
        return $this->createIfNotExists;
    }

    public function getType(): string
    {
        return FieldType::RESOURCE;
    }

    public function isPersist(): bool
    {
        return $this->persist;
    }

    public function getUniqueIdentifierField(): string
    {
        return $this->uniqueIdentifierField;
    }

    public function isAllowNullIfIdentifierIsPresent(): bool
    {
        return $this->allowNullIfIdentifierIsPresent;
    }

    public function isRemoveOldValueOnNull(): bool
    {
        return $this->removeOldValueOnNull;
    }
}
