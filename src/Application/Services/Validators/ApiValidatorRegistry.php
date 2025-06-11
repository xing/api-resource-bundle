<?php

namespace Prescreen\ApiResourceBundle\Application\Services\Validators;

use Prescreen\ApiResourceBundle\Application\Enum\FieldType;

class ApiValidatorRegistry
{
    /**
     * @param iterable<ApiValidatorInterface> $apiValidators
     */
    public function __construct(private readonly iterable $apiValidators)
    {
    }

    public function get(FieldType $type): ApiValidatorInterface
    {
        foreach ($this->apiValidators as $apiValidator) {
            if ($apiValidator->getType() === $type) {
                return $apiValidator;
            }
        }

        throw new \InvalidArgumentException('Undefined ApiValidator: ' . $type->value);
    }
}
