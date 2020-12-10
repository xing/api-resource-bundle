<?php

namespace Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions;

class IdField extends FieldOptions
{
    const TYPE = 'id';

    /**
     * @var string
     */
    private $entityClass;

    /**
     * @param string $entityClass
     * @param bool $required
     * @param string $type
     */
    public function __construct(
        string $entityClass,
        bool $required = false,
        string $type = self::TYPE
    ) {
        parent::__construct($type, $required);
        $this->entityClass = $entityClass;
    }

    /**
     * @return string
     */
    public function getEntityClass(): string
    {
        return $this->entityClass;
    }
}
