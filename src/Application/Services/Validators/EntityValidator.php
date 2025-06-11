<?php

namespace Prescreen\ApiResourceBundle\src\Application\Services\Validators;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Prescreen\ApiResourceBundle\src\Application\Configuration\FieldOptions\FieldOptions;
use Prescreen\ApiResourceBundle\src\Exception\LinkedObjectNotFoundException;

abstract class EntityValidator extends ApiValidator
{
    protected EntityRepository $repository;

    public function __construct(protected readonly EntityManagerInterface $em)
    {
    }

    /**
     * @throws LinkedObjectNotFoundException
     */
    protected function getEntity(int $id, string $fieldName, FieldOptions $fieldOptions, string $entityClass = null, string $idFieldName = 'id'): object
    {
        $entity = $this->repository->findOneBy([
            $idFieldName => $id
        ]);

        if (null === $entityClass && method_exists($fieldOptions, 'getEntityClass')) {
            $entityClass = $fieldOptions->getEntityClass();
        }

        $this->checkIfEntityNotNull($entity, $fieldName, $id, $entityClass);

        return $entity;
    }

    /**
     * @throws LinkedObjectNotFoundException
     */
    protected function checkIfEntityNotNull($entity, string $fieldName, int $id, string $entityClass): void
    {
        if (null === $entity) {
            throw new LinkedObjectNotFoundException($fieldName, sprintf('%s for id %s could not be found.', $entityClass, $id));
        }
    }
}
