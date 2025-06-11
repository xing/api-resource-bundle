<?php

namespace Prescreen\ApiResourceBundle\src\Application\ApiResources;

use Prescreen\ApiResourceBundle\src\Application\Interfaces\ApiResource;

class ExampleTranslationResource implements ApiResource
{
    public int $id;
    public string $name;
    public string $locale;

    public static function fromEntity(object $entity): ApiResource
    {
        $resource = new self();

        $resource->id = $entity->getId();
        $resource->name = $entity->getName();
        $resource->locale = $entity->getLocale();

        return $resource;
    }
}
