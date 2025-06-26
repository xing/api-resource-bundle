<?php

namespace Xing\ApiResourceBundle\Application\Interfaces;

interface ApiResource
{
    public static function fromEntity(object $entity): ApiResource;
}
