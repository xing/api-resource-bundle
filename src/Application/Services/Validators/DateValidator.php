<?php

namespace Prescreen\ApiResourceBundle\Application\Services\Validators;

use DateTime;
use Exception;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\FieldOptions;
use Prescreen\ApiResourceBundle\Application\Enum\FieldType;
use Prescreen\ApiResourceBundle\Exception\FieldTypeException;
use Prescreen\ApiResourceBundle\Exception\PermissionDeniedException;
use Prescreen\ApiResourceBundle\Exception\RequiredFieldMissingException;
use Prescreen\ApiResourceBundle\Exception\ValueNotAllowedException;

class DateValidator extends ApiValidator
{
    /**
     * @throws FieldTypeException
     * @throws RequiredFieldMissingException
     * @throws PermissionDeniedException
     * @throws ValueNotAllowedException
     */
    public function validate(string $fieldName, mixed $value, FieldOptions $fieldOptions, mixed $oldValue = null): ?DateTime
    {
        parent::validate($fieldName, $value, $fieldOptions, $oldValue);

        if (null !== $value) {
            try {
                return new DateTime($value);
            } catch (Exception) {
                throw new FieldTypeException($fieldName, 'Value must be a valid date.');
            }
        }

        return $value;
    }

    public function getType(): string
    {
        return FieldType::DATE;
    }
}
