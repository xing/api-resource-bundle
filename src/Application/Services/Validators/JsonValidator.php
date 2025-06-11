<?php

namespace Prescreen\ApiResourceBundle\src\Application\Services\Validators;

use Prescreen\ApiResourceBundle\src\Application\Configuration\FieldOptions\FieldOptions;
use Prescreen\ApiResourceBundle\src\Application\Configuration\FieldOptions\JsonField;
use Prescreen\ApiResourceBundle\src\Exception\FieldTypeException;
use Prescreen\ApiResourceBundle\src\Exception\PermissionDeniedException;
use Prescreen\ApiResourceBundle\src\Exception\RequiredFieldMissingException;
use Prescreen\ApiResourceBundle\src\Exception\ValueNotAllowedException;

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

    public function getType(): string
    {
        return JsonField::TYPE;
    }
}
