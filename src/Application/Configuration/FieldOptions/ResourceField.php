<?php

namespace Prescreen\ApiResourceBundle\src\Application\Configuration\FieldOptions;

class ResourceField extends FieldOptions
{
    const TYPE = 'resource';

    public function __construct(
        protected readonly string $resourceClass,
        protected readonly bool $createIfNotExists = false,
        bool $required = false,
        string $type = self::TYPE,
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
}
