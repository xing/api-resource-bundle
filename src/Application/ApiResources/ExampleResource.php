<?php

namespace Prescreen\ApiResourceBundle\Application\ApiResources;

use Prescreen\ApiResourceBundle\Application\Interfaces\ApiResource;
use Prescreen\ApiResourceBundle\Entity\ExampleTranslationEntity;

class ExampleResource implements ApiResource
{
    public int $id;
    public string $name;
    public bool $is_cool;
    /**
     * @var ExampleTranslationResource[]
     */
    public iterable $translations;

    public static function fromEntity(object $entity): ApiResource
    {
        $resource = new self();

        $resource->id = $entity->getId();
        $resource->name = $entity->getName();
        $resource->is_cool = $entity->isCool();
        $resource->translations = $entity->getTranslations()
            ->map(
                static fn (ExampleTranslationEntity $exampleTranslationEntity) =>
                ExampleTranslationResource::fromEntity($exampleTranslationEntity)
            );

        return $resource;
    }
}
