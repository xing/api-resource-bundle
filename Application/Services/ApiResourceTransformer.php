<?php

namespace Prescreen\ApiResourceBundle\Application\Services;

use Doctrine\Common\Collections\Collection;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\FieldOptions;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\ResourceCollectionField;
use Prescreen\ApiResourceBundle\Application\Interfaces\ApiResource;
use Prescreen\ApiResourceBundle\Application\Services\Traits\CaseConverter;
use Prescreen\ApiResourceBundle\Application\Services\Validators\ApiValidatorRegistry;
use Prescreen\ApiResourceBundle\Exception\RequiredFieldMissingException;
use Prescreen\ApiResourceBundle\Exception\WrongObjectTypeGivenException;

abstract class ApiResourceTransformer
{
    use CaseConverter;

    /**
     * @var ApiValidatorRegistry
     */
    protected $apiValidatorRegistry;
    /**
     * @var object
     */
    protected $resource;

    /**
     * @param ApiValidatorRegistry $apiValidatorRegistry
     */
    public function __construct(ApiValidatorRegistry $apiValidatorRegistry)
    {
        $this->apiValidatorRegistry = $apiValidatorRegistry;
    }

    abstract public function getEntityClass(): string;

    abstract public function getResourceClass(): string;

    abstract protected function setResourceFields(object $entity, ApiResource $resource): void;

    abstract protected function getWriteableFields(): array;

    /**
     * @param object $entity
     *
     * @throws WrongObjectTypeGivenException
     *
     * @return ApiResource
     */
    public function fromEntity(object $entity): ApiResource
    {
        $this->validateEntityClass($entity);

        $resource = $this->createResource($entity);

        $this->setResourceFields($entity, $resource);

        return $resource;
    }

    /**
     * @param iterable $iterable
     *
     * @throws WrongObjectTypeGivenException
     *
     * @return iterable
     */
    public function fromIterable(iterable $iterable): iterable
    {
        $resources = [];

        foreach ($iterable as $entity) {
            $resources[] = $this->fromEntity($entity);
        }

        return $resources;
    }

    /**
     * @param object $entity
     *
     * @throws WrongObjectTypeGivenException
     */
    protected function validateEntityClass(object $entity): void
    {
        $entityClass = $this->getEntityClass();

        if (!$entity instanceof $entityClass) {
            throw new WrongObjectTypeGivenException(sprintf('Class %s does not match expected class %s.', get_class($entity), $entityClass));
        }
    }

    /**
     * @param array $data
     * @param object $entityToFill
     *
     * @throws RequiredFieldMissingException
     *
     * @return object
     */
    public function fromArray(array $data, object $entityToFill): object
    {
        $writeableData = array_intersect_key($data, $this->getWriteableFields());
        $missingFields = array_diff_key($this->getRequiredFields(), $writeableData);

        if (count($missingFields) > 0) {
            throw new RequiredFieldMissingException('/', sprintf('One or more required fields are missing in the request: %s', implode(',', array_keys($missingFields))));
        }

        foreach ($writeableData as $fieldName => $value) {
            /** @var FieldOptions $fieldOptions */
            $fieldOptions = $this->getWriteableFields()[$fieldName];
            $entityGetter = $this->getEntityGetter($entityToFill, $fieldOptions, $fieldName);
            $oldValue = $entityToFill->{$entityGetter}();

            if (null !== $fieldOptions->getType()) {
                $validator = $this->apiValidatorRegistry->get($fieldOptions->getType());
                $value = $validator->validate($fieldName, $value, $fieldOptions, $oldValue);
            }

            if (ResourceCollectionField::TYPE === $fieldOptions->getType()) {
                $currentCollection = $oldValue;

                if (null === $currentCollection || 0 === count($currentCollection)) {
                    $this->setFieldWithEntitySetter($entityToFill, $fieldOptions, $fieldName, $value);
                } else {
                    $this->updateCollectionItems($currentCollection, $value, $entityToFill, $fieldOptions, $fieldName);
                }
            } else {
                $this->setFieldWithEntitySetter($entityToFill, $fieldOptions, $fieldName, $value);
            }
        }

        return $entityToFill;
    }

    /**
     * @return array
     */
    protected function getRequiredFields(): array
    {
        return array_filter($this->getWriteableFields(), function (FieldOptions $fieldOptions) {
            return $fieldOptions->isRequired();
        });
    }

    /**
     * @param object $entity
     *
     * @return ApiResource
     */
    protected function createResource(object $entity): ApiResource
    {
        $resourceClass = $this->getResourceClass();

        return $resourceClass::fromEntity($entity);
    }

    /**
     * @param object $entityToFill
     * @param FieldOptions $fieldOptions
     * @param string $fieldName
     *
     * @return string|null
     */
    protected function getEntityGetter(object $entityToFill, FieldOptions $fieldOptions, string $fieldName): ?string
    {
        return $this->getEntityMethod($entityToFill, $fieldOptions, 'getEntityGetter', $fieldName);
    }

    /**
     * @param object $entityToFill
     * @param FieldOptions $fieldOptions
     * @param string $fieldName
     *
     * @return string|null
     */
    protected function getEntitySetter(object $entityToFill, FieldOptions $fieldOptions, string $fieldName): ?string
    {
        return $this->getEntityMethod($entityToFill, $fieldOptions, 'getEntitySetter', $fieldName);
    }

    /**
     * @param object $entityToFill
     * @param FieldOptions $fieldOptions
     * @param string $fieldName
     *
     * @return string|null
     */
    protected function getEntityAdder(object $entityToFill, FieldOptions $fieldOptions, string $fieldName): ?string
    {
        return $this->getEntityMethod($entityToFill, $fieldOptions, 'getEntityAdder', $fieldName);
    }

    /**
     * @param object $entityToFill
     * @param FieldOptions $fieldOptions
     * @param string $fieldName
     *
     * @return string|null
     */
    protected function getEntityRemover(object $entityToFill, FieldOptions $fieldOptions, string $fieldName): ?string
    {
        return $this->getEntityMethod($entityToFill, $fieldOptions, 'getEntityRemover', $fieldName);
    }

    /**
     * @param object $entityToFill
     * @param FieldOptions $fieldOptions
     * @param string $fieldOptionsGetter
     * @param string $fieldName
     *
     * @return string|null
     */
    protected function getEntityMethod(object $entityToFill, FieldOptions $fieldOptions, string $fieldOptionsGetter, string $fieldName): ?string
    {
        $entityMethod = $fieldOptions->{$fieldOptionsGetter}();

        $methodPrefix = $this->getMethodPrefix($fieldOptionsGetter, $fieldName);

        if (null === $entityMethod) {
            $entityMethod = $this->composeEntityMethod($methodPrefix, $fieldName, $entityToFill);
        }

        if (method_exists($entityToFill, $entityMethod)) {
            return $entityMethod;
        }

        if (false !== strpos($fieldName, '_id')) {
            $entityMethod = $this->composeEntityMethod($methodPrefix, str_replace('_id', '', $fieldName), $entityToFill);

            if (method_exists($entityToFill, $entityMethod)) {
                return $entityMethod;
            }
        }

        throw new \InvalidArgumentException(sprintf('Entity method %s does not exist in entity %s.', $entityMethod, get_class($entityToFill)));
    }

    /**
     * @param object $entityToFill
     * @param FieldOptions $fieldOptions
     * @param string $fieldName
     * @param $value
     */
    protected function setFieldWithEntitySetter(object $entityToFill, FieldOptions $fieldOptions, string $fieldName, $value): void
    {
        $entitySetter = $this->getEntitySetter($entityToFill, $fieldOptions, $fieldName);
        $entityToFill->{$entitySetter}($value);
    }

    /**
     * @param Collection $currentCollection
     * @param Collection $newCollection
     * @param object $entityToFill
     * @param FieldOptions $fieldOptions
     * @param string $fieldName
     */
    protected function updateCollectionItems(Collection $currentCollection, Collection $newCollection, object $entityToFill, FieldOptions $fieldOptions, string $fieldName): void
    {
        $entityAdder = $this->getEntityAdder($entityToFill, $fieldOptions, $fieldName);
        $entityRemover = $this->getEntityRemover($entityToFill, $fieldOptions, $fieldName);

        foreach ($currentCollection as $item) {
            if (false === $newCollection->contains($item)) {
                $entityToFill->{$entityRemover}($item);
            }
        }

        foreach ($newCollection as $item) {
            if (false === $currentCollection->contains($item)) {
                $entityToFill->{$entityAdder}($item);
            }
        }
    }

    /**
     * @param string $fieldOptionsGetter
     * @param string $fieldName
     *
     * @return array|string
     */
    protected function getMethodPrefix(string $fieldOptionsGetter, string &$fieldName)
    {
        $methodPrefix = null;

        switch ($fieldOptionsGetter) {
            case 'getEntityGetter':
                $methodPrefix = ['get', '', 'is'];
                break;
            case 'getEntitySetter':
                $methodPrefix = 'set';
                break;
            case 'getEntityAdder':
                $methodPrefix = 'add';
                $fieldName = substr($fieldName, 0, -1);
                break;
            case 'getEntityRemover':
                $methodPrefix = 'remove';
                $fieldName = substr($fieldName, 0, -1);
                break;
            default:
                throw new \InvalidArgumentException(sprintf('Unknown field options method: %s', $fieldOptionsGetter));
        }

        return $methodPrefix;
    }

    /**
     * @param array|string $methodPrefix
     * @param string $fieldName
     * @param object $entityToFill
     *
     * @return string
     */
    protected function composeEntityMethod($methodPrefix, string $fieldName, object $entityToFill): string
    {
        if (is_array($methodPrefix)) {
            foreach ($methodPrefix as $prefix) {
                $entityMethod = $prefix . ucfirst($this->toCamelCase($fieldName));

                if (method_exists($entityToFill, $entityMethod)) {
                    break;
                }
            }
        } else {
            $entityMethod = $methodPrefix . ucfirst($this->toCamelCase($fieldName));
        }

        return $entityMethod;
    }

    /**
     * @param array $data
     * @param array $writeableFields
     *
     * @return array
     */
    protected function flattenDataArray(array $data, array $writeableFields): array
    {
        $flatData = [];

        foreach ($data as $key => $value) {
            if (array_key_exists($key, $writeableFields)) {
                $flatData[$key] = $value;
            } elseif (is_array($value)) {
                foreach ($value as $innerKey => $innerValue) {
                    if (array_key_exists($innerKey, $writeableFields)) {
                        $flatData[$innerKey] = $innerValue;
                    }
                }
            }
        }

        return $flatData;
    }
}
