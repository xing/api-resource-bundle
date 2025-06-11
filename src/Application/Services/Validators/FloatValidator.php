<?php

namespace Prescreen\ApiResourceBundle\Application\Services\Validators;

use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\FieldOptions;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\FloatField;
use Prescreen\ApiResourceBundle\Application\Services\Traits\RangeValidatorTrait;
use Prescreen\ApiResourceBundle\Exception\FieldOutOfRangeException;
use Prescreen\ApiResourceBundle\Exception\FieldTypeException;
use Prescreen\ApiResourceBundle\Exception\PermissionDeniedException;
use Prescreen\ApiResourceBundle\Exception\RequiredFieldMissingException;
use Prescreen\ApiResourceBundle\Exception\ValueNotAllowedException;

class FloatValidator extends ApiValidator
{
    use RangeValidatorTrait;

    /**
     * @throws FieldTypeException
     * @throws RequiredFieldMissingException
     * @throws PermissionDeniedException
     * @throws ValueNotAllowedException
     * @throws FieldOutOfRangeException
     */
    public function validate(string $fieldName, mixed $value, FieldOptions $fieldOptions, mixed $oldValue = null): float|int|null
    {
        parent::validate($fieldName, $value, $fieldOptions, $oldValue);

        if (!empty($value) && false === is_numeric($value)) {
            throw new FieldTypeException($fieldName, 'Value must be numeric.');
        }

        $this->validateRange($value, $fieldOptions, $fieldName);

        if ($value === '') {
            $value = null;
        }

        return $value;
    }

    public function getType(): string
    {
        return FloatField::TYPE;
    }
}
