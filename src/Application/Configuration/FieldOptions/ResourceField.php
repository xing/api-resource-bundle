<?php

namespace Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions;

use Prescreen\ApiResourceBundle\Application\Enum\FieldType;

class ResourceField extends FieldOptions
{
    public function __construct(
        protected readonly string $resourceClass,
        protected readonly bool $createIfNotExists = false,
        bool $required = false,
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
}
