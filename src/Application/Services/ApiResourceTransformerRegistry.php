<?php

namespace Xing\ApiResourceBundle\Application\Services;

class ApiResourceTransformerRegistry
{
    public function __construct(private readonly iterable $apiResourceTransformers)
    {
    }

    /**
     * @param string $resourceClass
     *
     * @return ApiResourceTransformer
     */
    public function get(string $resourceClass): ApiResourceTransformer
    {
        /** @var ApiResourceTransformer $apiResourceTransformer */
        foreach ($this->apiResourceTransformers as $apiResourceTransformer) {
            if ($apiResourceTransformer->getResourceClass() === $resourceClass) {
                return $apiResourceTransformer;
            }
        }

        throw new \InvalidArgumentException('Undefined ApiResourceTransformer: ' . $resourceClass);
    }
}
