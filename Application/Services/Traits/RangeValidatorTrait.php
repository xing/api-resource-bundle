<?php

namespace Prescreen\ApiResourceBundle\Application\Services\Traits;

use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\FieldOptions;
use Prescreen\ApiResourceBundle\Exception\FieldOutOfRangeException;

trait RangeValidatorTrait
{
    /**
     * @param mixed $value
     *
     * @throws FieldOutOfRangeException
     */
    protected function validateRange($value, FieldOptions $fieldOptions, string $fieldName): void
    {
        if (
            !empty($value) &&
            ((null !== $fieldOptions->getMin() && $value < $fieldOptions->getMin()) || (null !== $fieldOptions->getMax() && $value > $fieldOptions->getMax()))
        ) {
            throw new FieldOutOfRangeException(
                $fieldName,
                sprintf('Value must be in the range of %s to %s', $fieldOptions->getMin(), $fieldOptions->getMax())
            );
        }
    }
}
