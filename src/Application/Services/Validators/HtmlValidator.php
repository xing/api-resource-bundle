<?php

namespace Prescreen\ApiResourceBundle\Application\Services\Validators;

use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\FieldOptions;
use Prescreen\ApiResourceBundle\Application\Enum\FieldType;
use Prescreen\ApiResourceBundle\Application\Services\HtmlPurifier;
use Prescreen\ApiResourceBundle\Exception\FieldTypeException;
use Prescreen\ApiResourceBundle\Exception\PermissionDeniedException;
use Prescreen\ApiResourceBundle\Exception\RequiredFieldMissingException;
use Prescreen\ApiResourceBundle\Exception\ValueNotAllowedException;

class HtmlValidator extends ApiValidator
{
    public function __construct(private readonly HtmlPurifier $htmlPurifier)
    {
    }

    /**
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

        if (null !== $value && false === is_string($value)) {
            throw new FieldTypeException($fieldName, 'Value must be of type string.');
        }

        if (null !== $value && $fieldOptions->getPurify() === true) {
            $value = $this->htmlPurifier->purify($value);
        }

        return $value;
    }

    public function getType(): string
    {
        return FieldType::HTML;
    }
}
