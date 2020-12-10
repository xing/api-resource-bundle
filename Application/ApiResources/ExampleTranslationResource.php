<?php

namespace Prescreen\ApiResourceBundle\Application\ApiResources;

use Prescreen\ApiResourceBundle\Application\Interfaces\ApiResource;

class ExampleTranslationResource implements ApiResource
{
    /**
     * @var int
     */
    public $id;
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $locale;

    public static function fromEntity(object $entity): ApiResource
    {
        $resource = new self();

        $resource->id = $entity->getId();
        $resource->name = $entity->getName();
        $resource->locale = $entity->getLocale();

        return $resource;
    }
}
