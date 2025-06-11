<?php

namespace Prescreen\ApiResourceBundle\src\Application\Configuration\FieldOptions;

class IdField extends FieldOptions
{
    const string TYPE = 'id';

    public function __construct(
        protected readonly string $entityClass,
        bool $required = false,
        protected readonly string $idFieldName = 'id',
    ) {
        parent::__construct(self::TYPE, $required);
    }

    public function getEntityClass(): string
    {
        return $this->entityClass;
    }

    public function getIdFieldName(): string
    {
        return $this->idFieldName;
    }
}
