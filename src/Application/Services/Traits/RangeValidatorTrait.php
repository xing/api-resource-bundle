<?php

namespace Prescreen\ApiResourceBundle\src\Application\Services\Traits;

use Prescreen\ApiResourceBundle\src\Application\Configuration\FieldOptions\FieldOptions;
use Prescreen\ApiResourceBundle\src\Exception\FieldOutOfRangeException;

trait RangeValidatorTrait
{
    protected function validateRange(mixed $value, FieldOptions $fieldOptions, string $fieldName): void
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
