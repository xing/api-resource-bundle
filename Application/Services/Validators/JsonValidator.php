<?php

namespace Prescreen\ApiResourceBundle\Application\Services\Validators;

use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\FieldOptions;
use Prescreen\ApiResourceBundle\Exception\FieldTypeException;
use Prescreen\ApiResourceBundle\Exception\PermissionDeniedException;
use Prescreen\ApiResourceBundle\Exception\RequiredFieldMissingException;

class JsonValidator extends ApiValidator
{
    /**
     * @param string $fieldName
     * @param $value
     * @param FieldOptions $fieldOptions
     * @param $oldValue
     *
     * @return mixed
     * @throws RequiredFieldMissingException
     * @throws PermissionDeniedException|\Prescreen\ApiResourceBundle\Exception\ValueNotAllowedException
     *
     * @throws FieldTypeException
     */
    public function validate(string $fieldName, $value, FieldOptions $fieldOptions, $oldValue = null)
    {
        parent::validate($fieldName, $value, $fieldOptions, $oldValue);

        if (null !== $value && false === $this->isJson($value)) {
            throw new FieldTypeException($fieldName, 'Value must be of type json.');
        }

        return $value;
    }

    private function isJson($value)
    {
        if (is_array($value)) {
            $value = json_encode($value, 1);
        }

        json_decode($value);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    public function getType(): string
    {
        return JsonField::TYPE;
    }
}
