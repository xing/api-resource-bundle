<?php

namespace Xing\ApiResourceBundle\Application\Services\Validators;

use Xing\ApiResourceBundle\Application\Configuration\FieldOptions\FieldOptions;
use Xing\ApiResourceBundle\Application\Configuration\FieldOptions\StringField;
use Xing\ApiResourceBundle\Application\Enum\FieldType;
use Xing\ApiResourceBundle\Exception\FieldTypeException;
use Xing\ApiResourceBundle\Exception\PermissionDeniedException;
use Xing\ApiResourceBundle\Exception\RequiredFieldMissingException;
use Xing\ApiResourceBundle\Exception\ValueNotAllowedException;

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
        return FieldType::STRING;
    }
}
