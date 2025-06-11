<?php

namespace Prescreen\ApiResourceBundle\src\Application\Services\Validators;

class ApiValidatorRegistry
{
    /**
     * @param iterable<ApiValidatorInterface> $apiValidators
     */
    public function __construct(private readonly iterable $apiValidators)
    {
    }

    public function get(string $name): ApiValidatorInterface
    {
        foreach ($this->apiValidators as $apiValidator) {
            if ($apiValidator->getType() === $name) {
                return $apiValidator;
            }
        }

        throw new \InvalidArgumentException('Undefined ApiValidator: ' . $name);
    }
}
