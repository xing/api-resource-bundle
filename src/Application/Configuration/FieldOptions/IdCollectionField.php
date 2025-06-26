<?php

namespace Xing\ApiResourceBundle\Application\Configuration\FieldOptions;

use Xing\ApiResourceBundle\Application\Enum\FieldType;

class IdCollectionField extends IdField
{
    public function __construct(
        string $entityClass,
        bool $required = false,
        string $idFieldName = 'id',
    ) {
        parent::__construct($entityClass, $required, $idFieldName);
    }

    public function getType(): string
    {
        return FieldType::ID_COLLECTION;
    }
}
