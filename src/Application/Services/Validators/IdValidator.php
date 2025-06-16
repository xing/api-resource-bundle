<?php

namespace Prescreen\ApiResourceBundle\Application\Services\Validators;

use Doctrine\ORM\EntityManagerInterface;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\FieldOptions;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\IdField;
use Prescreen\ApiResourceBundle\Application\Enum\FieldType;
use Prescreen\ApiResourceBundle\Application\Services\Traits\EntityValidatorTrait;
use Prescreen\ApiResourceBundle\Exception\FieldTypeException;
use Prescreen\ApiResourceBundle\Exception\LinkedObjectNotFoundException;
use Prescreen\ApiResourceBundle\Exception\PermissionDeniedException;
use Prescreen\ApiResourceBundle\Exception\RequiredFieldMissingException;
use Prescreen\ApiResourceBundle\Exception\ValueNotAllowedException;

class IdValidator extends ApiValidator
{
    use EntityValidatorTrait;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @throws FieldTypeException
     * @throws LinkedObjectNotFoundException
     * @throws RequiredFieldMissingException
     * @throws PermissionDeniedException
     * @throws ValueNotAllowedException
     */
    public function validate(string $fieldName, mixed $value, FieldOptions $fieldOptions, $oldValue = null)
    {
        if (!$fieldOptions instanceof IdField) {
            throw new FieldTypeException($fieldName, sprintf(
                'Field type "id" requires an entity class to be set in the field options. Use %s to define the options for your id field. Field type used: "%s"',
                IdField::class,
                get_class($fieldOptions)
            ));
        }

        $this->repository = $this->em->getRepository($fieldOptions->getEntityClass());

        parent::validate($fieldName, $value, $fieldOptions, $oldValue);

        if (null !== $value) {
            if (false === is_int($value)) {
                throw new FieldTypeException($fieldName, 'Value must be of type integer.');
            }

            return $this->getEntity($value, $fieldName, $fieldOptions, null, $fieldOptions->getIdFieldName());
        }

        return null;
    }

    public function getType(): string
    {
        return FieldType::ID;
    }
}
