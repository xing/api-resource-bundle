<?php

namespace Xing\ApiResourceBundle\Application\Services\Validators;

use Xing\ApiResourceBundle\Application\Configuration\FieldOptions\FieldOptions;
use Xing\ApiResourceBundle\Application\Configuration\FieldOptions\JsonField;
use Xing\ApiResourceBundle\Application\Enum\FieldType;
use Xing\ApiResourceBundle\Exception\FieldTypeException;
use Xing\ApiResourceBundle\Exception\PermissionDeniedException;
use Xing\ApiResourceBundle\Exception\RequiredFieldMissingException;
use Xing\ApiResourceBundle\Exception\ValueNotAllowedException;

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
        return FieldType::JSON;
    }
}
