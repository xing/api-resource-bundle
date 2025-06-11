<?php

namespace Prescreen\ApiResourceBundle\Application\Interfaces;

interface ApiResource
{
    public static function fromEntity(object $entity): ApiResource;
}
