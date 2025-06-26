<?php

namespace Prescreen\ApiResourceBundle\Application\Services\Validators;

use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\FieldOptions;
use Prescreen\ApiResourceBundle\Application\Enum\FieldType;
use Prescreen\ApiResourceBundle\Application\Services\Traits\RangeValidatorTrait;
use Prescreen\ApiResourceBundle\Exception\FieldOutOfRangeException;
use Prescreen\ApiResourceBundle\Exception\FieldTypeException;
use Prescreen\ApiResourceBundle\Exception\PermissionDeniedException;
use Prescreen\ApiResourceBundle\Exception\RequiredFieldMissingException;
use Prescreen\ApiResourceBundle\Exception\ValueNotAllowedException;

class IntValidator extends ApiValidator
{
    use RangeValidatorTrait;

    /**
     * @throws FieldOutOfRangeException
     * @throws FieldTypeException
     * @throws RequiredFieldMissingException
     * @throws PermissionDeniedException
     * @throws ValueNotAllowedException
     */
    public function validate(string $fieldName, $value, FieldOptions $fieldOptions, $oldValue = null): ?int
    {
        parent::validate($fieldName, $value, $fieldOptions, $oldValue);

        if (!empty($value) && false === is_int($value)) {
            throw new FieldTypeException($fieldName, 'Value must be of type integer.');
        }

        $this->validateRange($value, $fieldOptions, $fieldName);

        return $value;
    }

    public function getType(): string
    {
        return FieldType::INT;
    }
}
