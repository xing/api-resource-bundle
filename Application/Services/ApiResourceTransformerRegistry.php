<?php

namespace Prescreen\ApiResourceBundle\Application\Services;

class ApiResourceTransformerRegistry
{
    /**
     * @var iterable
     */
    private $apiResourceTransformers;

    public function __construct(iterable $internalApiResourceTransformers)
    {
        $this->apiResourceTransformers = $internalApiResourceTransformers;
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

        throw new \InvalidArgumentException('Undefined InternalApiResourceTransformer: ' . $resourceClass);
    }
}
