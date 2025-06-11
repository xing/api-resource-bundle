<?php

namespace Prescreen\ApiResourceBundle\Application\Services\Validators;

use Doctrine\Common\Collections\ArrayCollection;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\FieldOptions;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\IdCollectionField;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\IdField;
use Prescreen\ApiResourceBundle\Exception\FieldTypeException;
use Prescreen\ApiResourceBundle\Exception\LinkedObjectNotFoundException;
use Prescreen\ApiResourceBundle\Exception\PermissionDeniedException;
use Prescreen\ApiResourceBundle\Exception\RequiredFieldMissingException;
use Prescreen\ApiResourceBundle\Exception\ValueNotAllowedException;

class IdCollectionValidator extends IdValidator
{
    /**
     * @throws FieldTypeException
     * @throws LinkedObjectNotFoundException
     * @throws RequiredFieldMissingException
     * @throws PermissionDeniedException
     * @throws ValueNotAllowedException
     */
    public function validate(string $fieldName, mixed $value, FieldOptions $fieldOptions, mixed $oldValue = null): ?ArrayCollection
    {
        if (!$fieldOptions instanceof IdField) {
            throw new FieldTypeException($fieldName, sprintf(
                'Field type "id" requires an entity class to be set in the field options. Use %s to define the options for your id field. Field type used: "%s"',
                IdField::class,
                get_class($fieldOptions)
            ));
        }

        if (null !== $value) {
            if (false === is_array($value)) {
                throw new FieldTypeException($fieldName, 'Value must be of type array.');
            }

            $entities = [];

            foreach ($value as $id) {
                $entities[] = parent::validate($fieldName, $id, $fieldOptions, $oldValue);
            }

            return new ArrayCollection($entities);
        }

        return null;
    }

    public function getType(): string
    {
        return IdCollectionField::TYPE;
    }
}
