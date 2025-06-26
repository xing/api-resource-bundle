<?php

namespace Xing\ApiResourceBundle\Application\Configuration\FieldOptions;

use Xing\ApiResourceBundle\Application\Enum\FieldType;

class ResourceCollectionField extends ResourceField
{
    public function __construct(
        string $resourceClass,
        bool $createIfNotExists = false,
        bool $required = false,
        protected readonly ?string $entityAdder = null,
        protected readonly ?string $entityRemover = null,
        bool $persist = true,
        string $uniqueIdentifierField = 'id',
        bool $allowNullIfIdentifierIsPresent = false,
        bool $removeOldValueOnNull = false,
    ) {
        parent::__construct(
            $resourceClass,
            $createIfNotExists,
            $required,
            $persist,
            $uniqueIdentifierField,
            $allowNullIfIdentifierIsPresent,
            $removeOldValueOnNull,
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

    public function getType(): string
    {
        return FieldType::RESOURCE_COLLECTION;
    }
}
