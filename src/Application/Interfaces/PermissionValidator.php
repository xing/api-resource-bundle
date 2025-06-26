<?php

namespace Xing\ApiResourceBundle\Application\Interfaces;

interface PermissionValidator
{
    public function isPermitted(): bool;
}
