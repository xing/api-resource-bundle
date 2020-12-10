<?php

namespace Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions;

class ResourceCollectionField extends ResourceField
{
    const TYPE = 'resource_collection';

    /**
     * @var string
     */
    protected $entityAdder;
    /**
     * @var string
     */
    protected $entityRemover;

    /**
     * @param string $resourceClass
     * @param bool $createIfNotExists
     * @param bool $required
     * @param string|null $entityAdder
     * @param string|null $entityRemover
     */
    public function __construct(
        string $resourceClass,
        bool $createIfNotExists = false,
        bool $required = false,
        string $entityAdder = null,
        string $entityRemover = null
    ) {
        parent::__construct($resourceClass, $createIfNotExists, $required, self::TYPE);

        $this->entityAdder = $entityAdder;
        $this->entityRemover = $entityRemover;
    }

    /**
     * @return string
     */
    public function getEntityAdder(): ?string
    {
        return $this->entityAdder;
    }

    /**
     * @return string
     */
    public function getEntityRemover(): ?string
    {
        return $this->entityRemover;
    }
}
