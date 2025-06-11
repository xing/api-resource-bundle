<?php

namespace Prescreen\ApiResourceBundle\Application\Services\Validators;

use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\FieldOptions;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\JsonField;
use Prescreen\ApiResourceBundle\Application\Enum\FieldType;
use Prescreen\ApiResourceBundle\Exception\FieldTypeException;
use Prescreen\ApiResourceBundle\Exception\PermissionDeniedException;
use Prescreen\ApiResourceBundle\Exception\RequiredFieldMissingException;
use Prescreen\ApiResourceBundle\Exception\ValueNotAllowedException;

class JsonValidator extends ApiValidator
{
    /**
     * @throws FieldTypeException
     * @throws PermissionDeniedException
     * @throws RequiredFieldMissingException
     * @throws ValueNotAllowedException
     */
    public function validate(string $fieldName, mixed $value, FieldOptions $fieldOptions, mixed $oldValue = null)
    {
        parent::validate($fieldName, $value, $fieldOptions, $oldValue);

        if (null !== $value && false === $this->isJson($value)) {
            throw new FieldTypeException($fieldName, 'Value must be of type json.');
        }

        return $value;
    }

    private function isJson($value): bool
    {
        if (is_array($value)) {
            $value = json_encode($value, 1);
        }

        return (json_validate($value));
    }

    public function getType(): FieldType
    {
        return FieldType::JSON;
    }
}
