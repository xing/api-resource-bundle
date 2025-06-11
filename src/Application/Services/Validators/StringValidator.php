<?php

namespace Prescreen\ApiResourceBundle\src\Application\Services\Validators;

use Prescreen\ApiResourceBundle\src\Application\Configuration\FieldOptions\FieldOptions;
use Prescreen\ApiResourceBundle\src\Application\Configuration\FieldOptions\StringField;
use Prescreen\ApiResourceBundle\src\Exception\FieldTypeException;
use Prescreen\ApiResourceBundle\src\Exception\PermissionDeniedException;
use Prescreen\ApiResourceBundle\src\Exception\RequiredFieldMissingException;
use Prescreen\ApiResourceBundle\src\Exception\ValueNotAllowedException;

class StringValidator extends ApiValidator
{
    /**
     * @throws FieldTypeException
     * @throws RequiredFieldMissingException
     * @throws PermissionDeniedException
     * @throws ValueNotAllowedException
     */
    public function validate(string $fieldName, $value, FieldOptions $fieldOptions, $oldValue = null): ?string
    {
        parent::validate($fieldName, $value, $fieldOptions, $oldValue);

        if (null !== $value && false === is_string($value)) {
            throw new FieldTypeException($fieldName, 'Value must be of type string.');
        }

        return $value;
    }

    public function getType(): string
    {
        return StringField::TYPE;
    }
}
