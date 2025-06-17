<?php

namespace Prescreen\ApiResourceBundle\Application\Services\Validators;

use Doctrine\Common\Collections\ArrayCollection;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\FieldOptions;
use Prescreen\ApiResourceBundle\Application\Enum\FieldType;
use Prescreen\ApiResourceBundle\Exception\FieldTypeException;
use Prescreen\ApiResourceBundle\Exception\LinkedObjectNotFoundException;
use Prescreen\ApiResourceBundle\Exception\MissingResourceTransformerException;
use Prescreen\ApiResourceBundle\Exception\PermissionDeniedException;
use Prescreen\ApiResourceBundle\Exception\RequiredFieldMissingException;
use Prescreen\ApiResourceBundle\Exception\ValueNotAllowedException;

class ResourceCollectionValidator extends ResourceValidator
{
    /**
     * @throws FieldTypeException
     * @throws LinkedObjectNotFoundException
     * @throws MissingResourceTransformerException
     * @throws RequiredFieldMissingException
     * @throws PermissionDeniedException
     * @throws ValueNotAllowedException
     */
    public function validate(string $fieldName, mixed $value, FieldOptions $fieldOptions, mixed $oldValue = null): ?ArrayCollection
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

        return null;
    }

    public function getType(): string
    {
        return FieldType::RESOURCE_COLLECTION;
    }
}
