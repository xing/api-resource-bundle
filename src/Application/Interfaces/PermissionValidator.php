<?php

namespace Prescreen\ApiResourceBundle\Application\Interfaces;

interface PermissionValidator
{
    public function isPermitted(): bool;
}
