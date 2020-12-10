<?php

namespace Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions;

class ResourceField extends FieldOptions
{
    const TYPE = 'resource';

    /**
     * @var string
     */
    protected $resourceClass;
    /**
     * @var bool
     */
    protected $createIfNotExists = false;

    /**
     * @param string $resourceClass
     * @param string $type
     * @param bool $createIfNotExists
     * @param bool $required
     */
    public function __construct(
        string $resourceClass,
        bool $createIfNotExists = false,
        bool $required = false,
        string $type = self::TYPE
    ) {
        parent::__construct($type, $required);
        $this->resourceClass = $resourceClass;
        $this->createIfNotExists = $createIfNotExists;
    }

    /**
     * @return string
     */
    public function getResourceClass(): string
    {
        return $this->resourceClass;
    }

    /**
     * @return bool
     */
    public function isCreateIfNotExists(): bool
    {
        return $this->createIfNotExists;
    }
}
