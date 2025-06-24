<?php

namespace Prescreen\ApiResourceBundle\Application\Services\Traits;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\FieldOptions;
use Prescreen\ApiResourceBundle\Exception\LinkedObjectNotFoundException;

trait EntityValidatorTrait
{
    protected ?EntityRepository $repository;
    protected EntityManagerInterface $em;

    /**
     * @throws LinkedObjectNotFoundException
     */
    protected function getEntity(
        mixed $id,
        string $fieldName,
        FieldOptions $fieldOptions,
        string $entityClass = null,
        string $idFieldName = 'id',
        bool $allowNull = false,
    ): ?object {
        $entity = $this->fetchEntity($idFieldName, $id, $fieldOptions);

        if (null === $entityClass && method_exists($fieldOptions, 'getEntityClass')) {
            $entityClass = $fieldOptions->getEntityClass();
        }

        if (false === $allowNull) {
            $this->checkIfEntityNotNull($entity, $fieldName, $id, $entityClass);
        }

        return $entity;
    }

    protected function fetchEntity(string $idFieldName, mixed $id, FieldOptions $fieldOptions): ?object
    {
        return $this->repository->findOneBy([
            $idFieldName => $id
        ]);
    }

    /**
     * @throws LinkedObjectNotFoundException
     */
    protected function checkIfEntityNotNull($entity, string $fieldName, mixed $id, string $entityClass): void
    {
        if (null === $entity) {
            throw new LinkedObjectNotFoundException($fieldName, sprintf('%s for id %s could not be found.', $entityClass, $id));
        }
    }
}
