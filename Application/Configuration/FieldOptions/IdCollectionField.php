<?php

namespace Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions;

class IdCollectionField extends IdField
{
    const TYPE = 'id_collection';

    /**
     * @param string $entityClass
     * @param bool $required
     */
    public function __construct(
        string $entityClass,
        bool $required = false
    ) {
        parent::__construct($entityClass, $required, self::TYPE);
    }
}
