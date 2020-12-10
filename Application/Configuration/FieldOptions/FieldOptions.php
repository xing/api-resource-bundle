<?php

namespace Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions;

use Prescreen\ApiResourceBundle\Application\Interfaces\PermissionValidator;

class FieldOptions
{
    /**
     * @var bool
     */
    protected $required = false;
    /**
     * @var string
     */
    protected $type;
    /**
     * @var string
     */
    protected $entitySetter;
    /**
     * @var string
     */
    protected $entityGetter;
    /**
     * @var mixed
     */
    protected $default;
    /**
     * @var array
     */
    protected $allowedValues;
    /**
     * @var string
     */
    protected $regex;
    /**
     * @var PermissionValidator
     */
    protected $permissionValidator;

    /**
     * @param string $type
     * @param bool $required
     * @param mixed|null $default
     */
    public function __construct(
        string $type,
        bool $required = false,
        $default = null
    ) {
        $this->required = $required;
        $this->type = $type;
        $this->default = $default;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->required;
    }

    /**
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getEntitySetter(): ?string
    {
        return $this->entitySetter;
    }

    /**
     * @param string $entitySetter
     *
     * @return FieldOptions
     */
    public function setEntitySetter(string $entitySetter): FieldOptions
    {
        $this->entitySetter = $entitySetter;
        return $this;
    }

    /**
     * @return string
     */
    public function getEntityGetter(): ?string
    {
        return $this->entityGetter;
    }

    /**
     * @param string $entityGetter
     *
     * @return FieldOptions
     */
    public function setEntityGetter(string $entityGetter): FieldOptions
    {
        $this->entityGetter = $entityGetter;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param array $allowedValues
     *
     * @return FieldOptions
     */
    public function setAllowedValues(array $allowedValues): FieldOptions
    {
        $this->allowedValues = $allowedValues;
        return $this;
    }

    /**
     * @return array
     */
    public function getAllowedValues(): ?array
    {
        return $this->allowedValues;
    }

    /**
     * @return string
     */
    public function getRegex(): ?string
    {
        return $this->regex;
    }

    /**
     * @return PermissionValidator
     */
    public function getPermissionValidator(): ?PermissionValidator
    {
        return $this->permissionValidator;
    }

    /**
     * @param PermissionValidator $permissionValidator
     *
     * @return FieldOptions
     */
    public function setPermissionValidator(PermissionValidator $permissionValidator): FieldOptions
    {
        $this->permissionValidator = $permissionValidator;
        return $this;
    }
}
