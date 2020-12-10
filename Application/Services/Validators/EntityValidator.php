<?php

namespace Prescreen\ApiResourceBundle\Application\Services\Validators;

use Doctrine\ORM\EntityManagerInterface;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\FieldOptions;
use Prescreen\ApiResourceBundle\Exception\LinkedObjectNotFoundException;
use Doctrine\ORM\EntityRepository;

abstract class EntityValidator extends ApiValidator
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;
    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param int $id
     * @param string $fieldName
     * @param FieldOptions $fieldOptions
     * @param string|null $entityClass
     *
     * @return object
     * @throws LinkedObjectNotFoundException
     */
    protected function getEntity(int $id, string $fieldName, FieldOptions $fieldOptions, string $entityClass = null): object
    {
        $entity = $this->repository->find($id);

        if (null === $entityClass && method_exists($fieldOptions, 'getEntityClass')) {
            $entityClass = $fieldOptions->getEntityClass();
        }

        $this->checkIfEntityNotNull($entity, $fieldName, $id, $entityClass);

        return $entity;
    }

    /**
     * @param $entity
     * @param string $fieldName
     * @param int $id
     * @param string $entityClass
     *
     * @throws LinkedObjectNotFoundException
     */
    protected function checkIfEntityNotNull($entity, string $fieldName, int $id, string $entityClass): void
    {
        if (null === $entity) {
            throw new LinkedObjectNotFoundException($fieldName, sprintf('%s for id %s could not be found.', $entityClass, $id));
        }
    }
}
