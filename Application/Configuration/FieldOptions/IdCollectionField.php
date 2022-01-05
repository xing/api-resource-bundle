<?php

namespace Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions;

class IdCollectionField extends IdField
{
    const TYPE = 'id_collection';

    /**
     * @param string $entityClass
     * @param bool $required
     * @param string $idFieldName
     */
    public function __construct(
        string $entityClass,
        bool $required = false,
        string $idFieldName = 'id'
    ) {
        parent::__construct($entityClass, $required, $idFieldName, self::TYPE);
    }
}
