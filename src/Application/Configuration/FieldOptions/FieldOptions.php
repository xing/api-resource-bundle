<?php

namespace Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions;

use Prescreen\ApiResourceBundle\Application\Interfaces\PermissionValidator;

abstract class FieldOptions
{
    protected ?string $entitySetter = null;
    protected ?string $entityGetter = null;
    protected ?array $allowedValues = null;
    protected ?string $regex = null;
    protected ?PermissionValidator $permissionValidator = null;

    abstract public function getType(): string;

    public function __construct(
        protected bool $required = false,
        protected mixed $default = null,
    ) {
    }

    public function isRequired(): bool
    {
        return $this->required;
    }


    public function getEntitySetter(): ?string
    {
        return $this->entitySetter;
    }

    public function setEntitySetter(string $entitySetter): static
    {
        $this->entitySetter = $entitySetter;
        return $this;
    }

    public function getEntityGetter(): ?string
    {
        return $this->entityGetter;
    }

    public function setEntityGetter(string $entityGetter): static
    {
        $this->entityGetter = $entityGetter;
        return $this;
    }

    public function getDefault(): mixed
    {
        return $this->default;
    }

    public function setAllowedValues(array $allowedValues): static
    {
        $this->allowedValues = $allowedValues;
        return $this;
    }

    public function getAllowedValues(): ?array
    {
        return $this->allowedValues;
    }

    public function getRegex(): ?string
    {
        return $this->regex;
    }

    public function getPermissionValidator(): ?PermissionValidator
    {
        return $this->permissionValidator;
    }

    public function setPermissionValidator(PermissionValidator $permissionValidator): static
    {
        $this->permissionValidator = $permissionValidator;
        return $this;
    }
}
