<?php

namespace Prescreen\ApiResourceBundle\Application\Interfaces;

/**
 * @template TEntity of object
 * @template TResource of ApiResource
 */
interface ApiResource
{
    /**
     * @param TEntity $entity
     *
     * @return TResource
     */
    public static function fromEntity(object $entity): ApiResource;
}
