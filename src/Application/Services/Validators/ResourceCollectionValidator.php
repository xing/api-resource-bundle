<?php

namespace Prescreen\ApiResourceBundle\src\Application\Services\Validators;

use Doctrine\Common\Collections\ArrayCollection;
use Prescreen\ApiResourceBundle\src\Application\Configuration\FieldOptions\FieldOptions;
use Prescreen\ApiResourceBundle\src\Application\Configuration\FieldOptions\ResourceCollectionField;
use Prescreen\ApiResourceBundle\src\Exception\FieldTypeException;
use Prescreen\ApiResourceBundle\src\Exception\LinkedObjectNotFoundException;
use Prescreen\ApiResourceBundle\src\Exception\MissingResourceTransformerException;
use Prescreen\ApiResourceBundle\src\Exception\RequiredFieldMissingException;

class ResourceCollectionValidator extends ResourceValidator
{
    /**
     * @throws FieldTypeException
     * @throws LinkedObjectNotFoundException
     * @throws MissingResourceTransformerException
     * @throws RequiredFieldMissingException
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
        return ResourceCollectionField::TYPE;
    }
}
