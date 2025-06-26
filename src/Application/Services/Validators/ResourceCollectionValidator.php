<?php

namespace Xing\ApiResourceBundle\Application\Services\Validators;

use Doctrine\Common\Collections\ArrayCollection;
use Xing\ApiResourceBundle\Application\Configuration\FieldOptions\FieldOptions;
use Xing\ApiResourceBundle\Application\Enum\FieldType;
use Xing\ApiResourceBundle\Exception\FieldTypeException;
use Xing\ApiResourceBundle\Exception\LinkedObjectNotFoundException;
use Xing\ApiResourceBundle\Exception\MissingResourceTransformerException;
use Xing\ApiResourceBundle\Exception\PermissionDeniedException;
use Xing\ApiResourceBundle\Exception\RequiredFieldMissingException;
use Xing\ApiResourceBundle\Exception\ValueNotAllowedException;

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
