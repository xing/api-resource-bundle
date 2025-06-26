<?php

namespace Xing\ApiResourceBundle\Application\Services\Validators;

class ApiValidatorRegistry
{
    /**
     * @param iterable<ApiValidatorInterface> $apiValidators
     */
    public function __construct(private readonly iterable $apiValidators)
    {
    }

    public function get(string $type): ApiValidatorInterface
    {
        foreach ($this->apiValidators as $apiValidator) {
            if ($apiValidator->getType() === $type) {
                return $apiValidator;
            }
        }

        throw new \InvalidArgumentException('Undefined ApiValidator: ' . $type);
    }
}
