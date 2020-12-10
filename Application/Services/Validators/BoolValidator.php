<?php

namespace Prescreen\ApiResourceBundle\Application\Services\Validators;

use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\BoolField;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\FieldOptions;
use Prescreen\ApiResourceBundle\Exception\FieldTypeException;
use Prescreen\ApiResourceBundle\Exception\PermissionDeniedException;
use Prescreen\ApiResourceBundle\Exception\RequiredFieldMissingException;
use Prescreen\ApiResourceBundle\Exception\ValueNotAllowedException;

class BoolValidator extends ApiValidator
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
     * @return mixed
     */
    public function validate(string $fieldName, $value, FieldOptions $fieldOptions, $oldValue = null)
    {
        parent::validate($fieldName, $value, $fieldOptions, $oldValue);

        if (null !== $value && false === is_bool($value)) {
            throw new FieldTypeException($fieldName, 'Value must be of type boolean.');
        }

        return $value;
    }

    public function getType(): string
    {
        return BoolField::TYPE;
    }
}
