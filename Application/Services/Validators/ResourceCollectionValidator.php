<?php

namespace Prescreen\ApiResourceBundle\Application\Services\Validators;

use Doctrine\Common\Collections\ArrayCollection;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\FieldOptions;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\ResourceCollectionField;
use Prescreen\ApiResourceBundle\Exception\FieldTypeException;
use Prescreen\ApiResourceBundle\Exception\LinkedObjectNotFoundException;
use Prescreen\ApiResourceBundle\Exception\MissingResourceTransformerException;
use Prescreen\ApiResourceBundle\Exception\PermissionDeniedException;
use Prescreen\ApiResourceBundle\Exception\RequiredFieldMissingException;
use Prescreen\ApiResourceBundle\Exception\ValueNotAllowedException;

class ResourceCollectionValidator extends ResourceValidator
{
    /**
     * @param string $fieldName
     * @param $value
     * @param FieldOptions $fieldOptions
     * @param $oldValue
     *
     * @throws FieldTypeException
     * @throws LinkedObjectNotFoundException
     * @throws MissingResourceTransformerException
     * @throws RequiredFieldMissingException
     * @throws PermissionDeniedException
     * @throws ValueNotAllowedException
     *
     * @return object
     */
    public function validate(string $fieldName, $value, FieldOptions $fieldOptions, $oldValue = null)
    {
        if (null !== $value) {
            if (false === is_array($value)) {
                throw new FieldTypeException($fieldName, 'Value must be of type array.');
            }

            $entities = [];

            foreach ($value as $resource) {
                $entities[] = parent::validate($fieldName, $resource, $fieldOptions, $oldValue);
            }

            return new ArrayCollection($entities);
        }

        return $value;
    }

    public function getType(): string
    {
        return ResourceCollectionField::TYPE;
    }
}
