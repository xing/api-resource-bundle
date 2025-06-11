<?php

namespace Prescreen\ApiResourceBundle\src\Application\Interfaces;

interface PermissionValidator
{
    public function isPermitted(): bool;
}
