<?php

namespace Prescreen\ApiResourceBundle\Application\Services\Validators;

class ApiValidatorRegistry
{
    /**
     * @var iterable
     */
    private $internalApiValidators;

    public function __construct(iterable $apiValidators)
    {
        $this->internalApiValidators = $apiValidators;
    }

    /**
     * @param string $name
     *
     * @return ApiValidatorInterface
     */
    public function get(string $name): ApiValidatorInterface
    {
        /** @var ApiValidatorInterface $internalApiValidator */
        foreach ($this->internalApiValidators as $internalApiValidator) {
            if ($internalApiValidator->getType() === $name) {
                return $internalApiValidator;
            }
        }

        throw new \InvalidArgumentException('Undefined InternalApiValidator: ' . $name);
    }
}
