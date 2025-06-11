<?php

namespace Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions;

class IdCollectionField extends IdField
{
    const string TYPE = 'id_collection';

    public function __construct(
        string $entityClass,
        bool $required = false,
        string $idFieldName = 'id',
    ) {
        parent::__construct($entityClass, $required, $idFieldName, self::TYPE);
    }
}
