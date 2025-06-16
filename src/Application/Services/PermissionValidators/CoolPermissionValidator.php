<?php

namespace Prescreen\ApiResourceBundle\Application\Services\PermissionValidators;

use Prescreen\ApiResourceBundle\Application\Interfaces\PermissionValidator;

readonly class CoolPermissionValidator implements PermissionValidator
{
    public function __construct(private bool $userIsCool)
    {
    }

    public function isPermitted(): bool
    {
        return $this->userIsCool;
    }
}
