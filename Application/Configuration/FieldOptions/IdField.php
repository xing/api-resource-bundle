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
     * @var string
     */
    private $idFieldName = 'id';

    /**
     * @param string $entityClass
     * @param bool $required
     * @param string $idFieldName
     * @param string $type
     */
    public function __construct(
        string $entityClass,
        bool $required = false,
        string $idFieldName = 'id',
        string $type = self::TYPE
    ) {
        parent::__construct($type, $required);
        $this->entityClass = $entityClass;
        $this->idFieldName = $idFieldName;
    }

    /**
     * @return string
     */
    public function getEntityClass(): string
    {
        return $this->entityClass;
    }

    /**
     * @return string
     */
    public function getIdFieldName(): string
    {
        return $this->idFieldName;
    }
}
