<?php

namespace Prescreen\ApiResourceBundle\Application\Services\Validators;

use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\FieldOptions;
use Prescreen\ApiResourceBundle\Exception\PermissionDeniedException;
use Prescreen\ApiResourceBundle\Exception\RequiredFieldMissingException;
use Prescreen\ApiResourceBundle\Exception\ValueNotAllowedException;

abstract class ApiValidator implements ApiValidatorInterface
{
    /**
     * @throws ValueNotAllowedException
     * @throws RequiredFieldMissingException
     * @throws PermissionDeniedException
     */
    public function validate(string $fieldName, mixed $value, FieldOptions $fieldOptions, $oldValue = null)
    {
        if (null === $value && true === $fieldOptions->isRequired()) {
            throw new RequiredFieldMissingException($fieldName, 'Value cannot be null.');
        }

        if (null !== $value) {
            if (null !== $fieldOptions->getAllowedValues() && false === in_array($value, $fieldOptions->getAllowedValues())) {
                throw new ValueNotAllowedException($fieldName, sprintf('Value is not allowed. Allowed values are: %s.', json_encode($fieldOptions->getAllowedValues())));
            }

            if (null !== $fieldOptions->getRegex() && 1 !== preg_match($fieldOptions->getRegex(), $value)) {
                throw new ValueNotAllowedException($fieldName, sprintf('Value does not match regular expression: %s', $fieldOptions->getRegex()));
            }
        }

        if (
            null !== $fieldOptions->getPermissionValidator() &&
            $value !== $oldValue &&
            false === $fieldOptions->getPermissionValidator()->isPermitted()
        ) {
            throw new PermissionDeniedException($fieldName, 'The requesting user does not have the required permissions to change this field.');
        }

        return $value;
    }
}
