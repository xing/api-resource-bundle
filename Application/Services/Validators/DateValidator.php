<?php

namespace Prescreen\ApiResourceBundle\Application\Services\Validators;

use DateTime;
use Exception;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\DateField;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\FieldOptions;
use Prescreen\ApiResourceBundle\Exception\FieldTypeException;
use Prescreen\ApiResourceBundle\Exception\PermissionDeniedException;
use Prescreen\ApiResourceBundle\Exception\RequiredFieldMissingException;
use Prescreen\ApiResourceBundle\Exception\ValueNotAllowedException;

class DateValidator extends ApiValidator
{
    /**
     * @param string $fieldName
     * @param $value
     * @param FieldOptions $fieldOptions
     * @param $oldValue
     *
     * @throws FieldTypeException
     * @throws RequiredFieldMissingException
     * @throws PermissionDeniedException
     * @throws ValueNotAllowedException
     *
     * @return DateTime
     */
    public function validate(string $fieldName, $value, FieldOptions $fieldOptions, $oldValue = null)
    {
        parent::validate($fieldName, $value, $fieldOptions, $oldValue);

        if (null !== $value) {
            try {
                $dateTime = new DateTime($value);
                return $dateTime;
            } catch (Exception $e) {
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
