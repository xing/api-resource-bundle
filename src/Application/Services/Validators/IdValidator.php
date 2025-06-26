<?php

namespace Xing\ApiResourceBundle\Application\Services\Validators;

use Doctrine\ORM\EntityManagerInterface;
use Xing\ApiResourceBundle\Application\Configuration\FieldOptions\FieldOptions;
use Xing\ApiResourceBundle\Application\Configuration\FieldOptions\IdField;
use Xing\ApiResourceBundle\Application\Enum\FieldType;
use Xing\ApiResourceBundle\Application\Services\Traits\EntityValidatorTrait;
use Xing\ApiResourceBundle\Exception\FieldTypeException;
use Xing\ApiResourceBundle\Exception\LinkedObjectNotFoundException;
use Xing\ApiResourceBundle\Exception\PermissionDeniedException;
use Xing\ApiResourceBundle\Exception\RequiredFieldMissingException;
use Xing\ApiResourceBundle\Exception\ValueNotAllowedException;

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
            return $this->getEntity($value, $fieldName, $fieldOptions, null, $fieldOptions->getIdFieldName());
        }

        return null;
    }

    public function getType(): string
    {
        return FieldType::ID;
    }
}
