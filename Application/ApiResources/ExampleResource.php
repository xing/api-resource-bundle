<?php

namespace Prescreen\ApiResourceBundle\Application\ApiResources;

use Prescreen\ApiResourceBundle\Application\Interfaces\ApiResource;
use Prescreen\ApiResourceBundle\Entity\ExampleTranslationEntity;

class ExampleResource implements ApiResource
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
     * @var bool
     */
    public $is_cool;
    /**
     * @var array<ExampleTranslationResource>
     */
    public $translations;

    public static function fromEntity(object $entity): ApiResource
    {
        $resource = new self();

        $resource->id = $entity->getId();
        $resource->name = $entity->getName();
        $resource->is_cool = $entity->isCool();
        $resource->translations = $entity->getTranslations()->map(function (ExampleTranslationEntity $exampleTranslationEntity) {
            return ExampleTranslationResource::fromEntity($exampleTranslationEntity);
        });

        return $resource;
    }
}
