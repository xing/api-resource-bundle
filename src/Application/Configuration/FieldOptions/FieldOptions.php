<?php

namespace Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions;

use Prescreen\ApiResourceBundle\Application\Interfaces\PermissionValidator;

class FieldOptions
{
    protected bool $required = false;
    protected string $type;
    protected ?string $entitySetter = null;
    protected ?string $entityGetter = null;
    protected mixed $default = null;
    protected ?array $allowedValues = null;
    protected ?string $regex = null;
    protected ?PermissionValidator $permissionValidator = null;

    public function __construct(
        string $type,
        bool $required = false,
        mixed $default = null,
    ) {
        $this->required = $required;
        $this->type = $type;
        $this->default = $default;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function getType(): string
    {
        return $this->type;
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
