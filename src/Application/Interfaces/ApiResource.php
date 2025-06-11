<?php

namespace Prescreen\ApiResourceBundle\src\Application\Interfaces;

interface ApiResource
{
    public static function fromEntity(object $entity): ApiResource;
}
