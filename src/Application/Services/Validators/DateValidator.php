<?php

namespace Xing\ApiResourceBundle\Application\Services\Validators;

use DateTime;
use Exception;
use Xing\ApiResourceBundle\Application\Configuration\FieldOptions\FieldOptions;
use Xing\ApiResourceBundle\Application\Enum\FieldType;
use Xing\ApiResourceBundle\Exception\FieldTypeException;
use Xing\ApiResourceBundle\Exception\PermissionDeniedException;
use Xing\ApiResourceBundle\Exception\RequiredFieldMissingException;
use Xing\ApiResourceBundle\Exception\ValueNotAllowedException;

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
