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

        if ($value === '') {
            $value = null;
        }

        return $value;
    }

    public function getType(): string
    {
        return FieldType::INT;
    }
}
