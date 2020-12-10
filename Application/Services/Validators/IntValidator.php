<?php

namespace Prescreen\ApiResourceBundle\Application\Services\Validators;

use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\FieldOptions;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\IntField;
use Prescreen\ApiResourceBundle\Exception\FieldOutOfRangeException;
use Prescreen\ApiResourceBundle\Exception\FieldTypeException;
use Prescreen\ApiResourceBundle\Exception\PermissionDeniedException;
use Prescreen\ApiResourceBundle\Exception\RequiredFieldMissingException;
use Prescreen\ApiResourceBundle\Exception\ValueNotAllowedException;

class IntValidator extends ApiValidator
{
    /**
     * @param string $fieldName
     * @param $value
     * @param FieldOptions $fieldOptions
     * @param $oldValue
     *
     * @throws FieldOutOfRangeException
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

        if (!empty($value) && false === is_int($value)) {
            throw new FieldTypeException($fieldName, 'Value must be of type integer.');
        }

        if (
            !empty($value) &&
            ((null !== $fieldOptions->getMin() && $value < $fieldOptions->getMin()) || (null !== $fieldOptions->getMax() && $value > $fieldOptions->getMax()))
        ) {
            throw new FieldOutOfRangeException(
                $fieldName,
                sprintf('Value must be in the range of %s to %s', $fieldOptions->getMin(), $fieldOptions->getMax())
            );
        }

        if ($value === '') {
            $value = null;
        }

        return $value;
    }

    public function getType(): string
    {
        return IntField::TYPE;
    }
}
