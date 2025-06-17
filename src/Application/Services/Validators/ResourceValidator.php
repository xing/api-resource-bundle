<?php

namespace Prescreen\ApiResourceBundle\Application\Services\Validators;

use Doctrine\ORM\EntityManagerInterface;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\FieldOptions;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\ResourceField;
use Prescreen\ApiResourceBundle\Application\Enum\FieldType;
use Prescreen\ApiResourceBundle\Application\Services\ApiResourceTransformer;
use Prescreen\ApiResourceBundle\Application\Services\ApiResourceTransformerRegistry;
use Prescreen\ApiResourceBundle\Application\Services\Traits\EntityValidatorTrait;
use Prescreen\ApiResourceBundle\Exception\FieldTypeException;
use Prescreen\ApiResourceBundle\Exception\LinkedObjectNotFoundException;
use Prescreen\ApiResourceBundle\Exception\MissingResourceTransformerException;
use Prescreen\ApiResourceBundle\Exception\PermissionDeniedException;
use Prescreen\ApiResourceBundle\Exception\RequiredFieldMissingException;
use Prescreen\ApiResourceBundle\Exception\ValueNotAllowedException;

class ResourceValidator extends ApiValidator
{
    use EntityValidatorTrait;

    public function __construct(
        EntityManagerInterface $em,
        protected readonly ApiResourceTransformerRegistry $apiResourceTransformerRegistry
    ) {
        $this->em = $em;
    }

    /**
     * @throws FieldTypeException
     * @throws LinkedObjectNotFoundException
     * @throws MissingResourceTransformerException
     * @throws RequiredFieldMissingException
     * @throws PermissionDeniedException
     * @throws ValueNotAllowedException
     */
    public function validate(string $fieldName, mixed $value, FieldOptions $fieldOptions, mixed $oldValue = null)
    {
        if (!$fieldOptions instanceof ResourceField) {
            throw new FieldTypeException($fieldName, sprintf(
                'Field type "resource" requires a resource class to be set in the field options. Use %s to define the options for your resource field. Field type used: "%s"',
                ResourceField::class,
                get_class($fieldOptions)
            ));
        }

        $resourceTransformer = $this->getResourceTransformer($fieldOptions->getResourceClass(), $fieldName, $fieldOptions);

        $this->repository = $this->em->getRepository($resourceTransformer->getEntityClass());

        parent::validate($fieldName, $value, $fieldOptions, $oldValue);

        if (null !== $value) {
            if (false === is_array($value)) {
                throw new FieldTypeException($fieldName, 'Value must be of type array.');
            }

            $entity = null;
            $entityClass = $resourceTransformer->getEntityClass();

            if (isset($value[$fieldOptions->getUniqueIdentifierField()])) {
                $entity = $this->getEntity(
                    $value[$fieldOptions->getUniqueIdentifierField()],
                    $fieldName,
                    $fieldOptions,
                    $resourceTransformer->getEntityClass(),
                    $fieldOptions->getUniqueIdentifierField(),
                    $fieldOptions->isAllowNullIfIdentifierIsPresent(),
                );

                if (null === $entity && true === $fieldOptions->isCreateIfNotExists()) {
                    $entity = new $entityClass();
                }
            } elseif (true === $fieldOptions->isCreateIfNotExists()) {
                $entity = new $entityClass;
            }

            if (null !== $entity) {
                $this->fillEntity($resourceTransformer, $value, $entity, $fieldOptions);

                if (true === $fieldOptions->isPersist()) {
                    $this->em->persist($entity);
                }

                return $entity;
            } elseif (true === $fieldOptions->isRequired()) {
                throw new RequiredFieldMissingException($fieldName, 'id for the resource must be present.');
            }

            return null;
        } elseif (null !== $oldValue && true === $fieldOptions->isRemoveOldValueOnNull()) {
            $this->removeOldValue($oldValue);
        }

        return null;
    }

    public function getType(): string
    {
        return FieldType::RESOURCE;
    }

    /**
     * @throws MissingResourceTransformerException
     */
    protected function getResourceTransformer(
        string $resourceClass,
        string $fieldName,
        FieldOptions $fieldOptions,
    ): ApiResourceTransformer {
        try {
            return $this->apiResourceTransformerRegistry->get($resourceClass);
        } catch (\InvalidArgumentException) {
            throw new MissingResourceTransformerException($fieldName, sprintf('No resource transformer has been registered for the resource %s.', $resourceClass));
        }
    }

    protected function removeOldValue(object $oldValue): void
    {
        $this->em->remove($oldValue);
    }

    /**
     * @throws RequiredFieldMissingException
     */
    public function fillEntity(
        ApiResourceTransformer $resourceTransformer,
        array $value,
        object $entity,
        FieldOptions $fieldOptions,
    ): object {
        return $resourceTransformer->fromArray($value, $entity);
    }
}
