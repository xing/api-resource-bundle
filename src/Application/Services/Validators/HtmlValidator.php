<?php

namespace Xing\ApiResourceBundle\Application\Services\Validators;

use Xing\ApiResourceBundle\Application\Configuration\FieldOptions\FieldOptions;
use Xing\ApiResourceBundle\Application\Enum\FieldType;
use Xing\ApiResourceBundle\Application\Services\HtmlPurifier;
use Xing\ApiResourceBundle\Exception\FieldTypeException;
use Xing\ApiResourceBundle\Exception\PermissionDeniedException;
use Xing\ApiResourceBundle\Exception\RequiredFieldMissingException;
use Xing\ApiResourceBundle\Exception\ValueNotAllowedException;

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
