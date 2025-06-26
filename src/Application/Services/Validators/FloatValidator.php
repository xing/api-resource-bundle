<?php

namespace Xing\ApiResourceBundle\Application\Services\Validators;

use Xing\ApiResourceBundle\Application\Configuration\FieldOptions\FieldOptions;
use Xing\ApiResourceBundle\Application\Enum\FieldType;
use Xing\ApiResourceBundle\Application\Services\Traits\RangeValidatorTrait;
use Xing\ApiResourceBundle\Exception\FieldOutOfRangeException;
use Xing\ApiResourceBundle\Exception\FieldTypeException;
use Xing\ApiResourceBundle\Exception\PermissionDeniedException;
use Xing\ApiResourceBundle\Exception\RequiredFieldMissingException;
use Xing\ApiResourceBundle\Exception\ValueNotAllowedException;

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
        return FieldType::FLOAT;
    }
}
