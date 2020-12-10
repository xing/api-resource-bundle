<?php

namespace Prescreen\ApiResourceBundle\Application\Services\PermissionValidators;

use Prescreen\ApiResourceBundle\Application\Interfaces\PermissionValidator;

class CoolPermissionValidator implements PermissionValidator
{
    /**
     * @var bool
     */
    private $userIsCool;

    /**
     * @param bool $userIsCool
     */
    public function __construct(bool $userIsCool)
    {
        $this->userIsCool = $userIsCool;
    }

    public function isPermitted(): bool
    {
        return $this->userIsCool;
    }
}
