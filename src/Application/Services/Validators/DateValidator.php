<?php

namespace Prescreen\ApiResourceBundle\src\Application\Services\Validators;

use DateTime;
use Exception;
use Prescreen\ApiResourceBundle\src\Application\Configuration\FieldOptions\DateField;
use Prescreen\ApiResourceBundle\src\Application\Configuration\FieldOptions\FieldOptions;
use Prescreen\ApiResourceBundle\src\Exception\FieldTypeException;
use Prescreen\ApiResourceBundle\src\Exception\PermissionDeniedException;
use Prescreen\ApiResourceBundle\src\Exception\RequiredFieldMissingException;
use Prescreen\ApiResourceBundle\src\Exception\ValueNotAllowedException;

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
        return DateField::TYPE;
    }
}
