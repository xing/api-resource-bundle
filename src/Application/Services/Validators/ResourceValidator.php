<?php

namespace Prescreen\ApiResourceBundle\Application\Services\Validators;

use Doctrine\ORM\EntityManagerInterface;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\FieldOptions;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\ResourceField;
use Prescreen\ApiResourceBundle\Application\Services\ApiResourceTransformerRegistry;
use Prescreen\ApiResourceBundle\Exception\FieldTypeException;
use Prescreen\ApiResourceBundle\Exception\LinkedObjectNotFoundException;
use Prescreen\ApiResourceBundle\Exception\MissingResourceTransformerException;
use Prescreen\ApiResourceBundle\Exception\PermissionDeniedException;
use Prescreen\ApiResourceBundle\Exception\RequiredFieldMissingException;
use Prescreen\ApiResourceBundle\Exception\ValueNotAllowedException;

class ResourceValidator extends EntityValidator
{
    public function __construct(
        EntityManagerInterface $em,
        protected readonly ApiResourceTransformerRegistry $apiResourceTransformerRegistry
    ) {
        parent::__construct($em);
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

        try {
            $resourceTransformer = $this->apiResourceTransformerRegistry->get($fieldOptions->getResourceClass());
        } catch (\InvalidArgumentException) {
            throw new MissingResourceTransformerException($fieldName, sprintf('No resource transformer has been registered for the resource %s.', $fieldOptions->getResourceClass()));
        }

        $this->repository = $this->em->getRepository($resourceTransformer->getEntityClass());

        parent::validate($fieldName, $value, $fieldOptions, $oldValue);

        if (null !== $value) {
            if (false === is_array($value)) {
                throw new FieldTypeException($fieldName, 'Value must be of type array.');
            }

            $entity = null;

            if (isset($value['id'])) {
                $entity = $this->getEntity($value['id'], $fieldName, $fieldOptions, $resourceTransformer->getEntityClass());
            } elseif (true === $fieldOptions->isCreateIfNotExists()) {
                $entityClass = $resourceTransformer->getEntityClass();
                $entity = new $entityClass;
                $this->em->persist($entity);
            }

            if (null !== $entity) {
                $resourceTransformer->fromArray($value, $entity);

                return $entity;
            } elseif (true === $fieldOptions->isRequired()) {
                throw new RequiredFieldMissingException($fieldName, 'id for the resource must be present.');
            }

            return null;
        }

        return null;
    }

    public function getType(): string
    {
        return ResourceField::TYPE;
    }
}
