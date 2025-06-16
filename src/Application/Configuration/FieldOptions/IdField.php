<?php

namespace Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions;

use Prescreen\ApiResourceBundle\Application\Enum\FieldType;

class IdField extends FieldOptions
{
    public function __construct(
        protected readonly string $entityClass,
        bool $required = false,
        protected readonly string $idFieldName = 'id',
    ) {
        parent::__construct($required);
    }

    public function getEntityClass(): string
    {
        return $this->entityClass;
    }

    public function getIdFieldName(): string
    {
        return $this->idFieldName;
    }

    public function getType(): string
    {
        return FieldType::ID;
    }
}
