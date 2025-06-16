<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Services\Validators;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Prescreen\ApiResourceBundle\Application\ApiResources\ExampleResource;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\IdField;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\ResourceField;
use Prescreen\ApiResourceBundle\Application\Enum\FieldType;
use Prescreen\ApiResourceBundle\Application\Services\ApiResourceTransformer;
use Prescreen\ApiResourceBundle\Application\Services\ApiResourceTransformerRegistry;
use Prescreen\ApiResourceBundle\Application\Services\Validators\ResourceValidator;
use Prescreen\ApiResourceBundle\Entity\ExampleEntity;
use Prescreen\ApiResourceBundle\Exception\FieldTypeException;
use Prescreen\ApiResourceBundle\Exception\MissingResourceTransformerException;
use Prescreen\ApiResourceBundle\Exception\RequiredFieldMissingException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ResourceValidatorTest extends TestCase
{
    protected ApiResourceTransformerRegistry $apiResourceTransformerRegistry;
    protected EntityManagerInterface $em;
    private ResourceValidator $testService;

    public function setUp(): void
    {
        $this->apiResourceTransformerRegistry = $this->createMock(ApiResourceTransformerRegistry::class);
        $this->em = $this->createMock(EntityManagerInterface::class);
        $this->testService = new ResourceValidator($this->em, $this->apiResourceTransformerRegistry);
    }

    public function testItThrowsExceptionIfFieldOptionsAreNotOfTypeResourceField(): void
    {
        $this->expectException(FieldTypeException::class);

        $this->testService->validate('resource_field', null, new IdField(ExampleEntity::class));
    }

    public function testItThrowsExceptionIfResourceTransformerForResourceHasNotBeenRegistered(): void
    {
        $this->expectException(MissingResourceTransformerException::class);

        $this->apiResourceTransformerRegistry->expects($this->once())->method('get')->willThrowException(new \InvalidArgumentException());

        $this->testService->validate('resource_field', null, new ResourceField(ExampleResource::class));
    }

    public function testItThrowsExceptionIfValueIsNotOfTypeArray(): void
    {
        $this->expectException(FieldTypeException::class);

        $this->expectRepositoryToBeFound();
        $this->expectResourceTransformerToBeReturned();

        $this->testService->validate('resource_field', 1, $this->createResourceField(false, true));
    }

    public function testItThrowsExceptionIfEntityIsNullButFieldIsRequired(): void
    {
        $this->expectException(RequiredFieldMissingException::class);

        $this->expectRepositoryToBeFound();
        $this->expectResourceTransformerToBeReturned();

        $this->testService->validate('resource_field', ['foo' => 1], $this->createResourceField(false, true));
    }

    public function testItThrowsExceptionIfNoIdAndResourceShouldNotBeCreatedButFieldIsRequired(): void
    {
        $this->expectException(RequiredFieldMissingException::class);

        $this->expectRepositoryToBeFound();
        $this->expectResourceTransformerToBeReturned();

        $this->testService->validate('resource_field', ['foo' => 1], $this->createResourceField(false, true));
    }

    public function testItGetsEntityWithRepositoryIfGivenId(): void
    {
        $resourceTransformer = $this->expectResourceTransformerToBeReturned();
        $resourceTransformer->method('getEntityClass')->willReturn(ExampleEntity::class);
        $resourceTransformer->expects($this->once())->method('fromArray');

        $repository = $this->expectRepositoryToBeFound();
        $exampleEntity = new ExampleEntity();
        $repository->expects($this->once())->method('findOneBy')->willReturn($exampleEntity);

        $fieldOptions = $this->createResourceField(false, true);

        $this->testService->validate('resource_field', ['id' => 1], $fieldOptions);
    }

    public function testItCreatesNewEntityFromResourceIfNoIdAndCreateIfNotExistsGiven(): void
    {
        $resourceTransformer = $this->expectResourceTransformerToBeReturned();
        $resourceTransformer->method('getEntityClass')->willReturn(ExampleEntity::class);

        $fieldOptions = $this->createResourceField(true, true);

        $this->expectRepositoryToBeFound();

        $this->em->expects($this->once())->method('persist');

        $returnedEntity = $this->testService->validate('resource_field', ['foo' => 'bar'], $fieldOptions);

        $this->assertInstanceOf(ExampleEntity::class, $returnedEntity);
    }

    public function testItReturnsNullIfNoIdAndNoCreateIfNotExistsAndFieldIsNotRequired(): void
    {
        $this->expectResourceTransformerToBeReturned();
        $this->expectRepositoryToBeFound();

        $this->assertNull($this->testService->validate('resource_field', ['foo' => 'bar'], $this->createResourceField(false, false)));
    }

    public function testItReturnsNullIfValueIsNullAndFieldIsNotRequired(): void
    {
        $this->expectResourceTransformerToBeReturned();
        $this->expectRepositoryToBeFound();

        $this->assertNull($this->testService->validate('resource_field', null, $this->createResourceField(false, false)));
    }

    public function testItCreatesNewEntityIfIdentifierFieldIsGivenButEntityCouldNotBeFound(): void
    {
        $resourceTransformer = $this->expectResourceTransformerToBeReturned();
        $resourceTransformer->method('getEntityClass')->willReturn(ExampleEntity::class);

        $this->expectRepositoryToBeFound();

        $this->em->expects($this->once())->method('persist')->with($this->callback(function (ExampleEntity $entity) {
            return true;
        }));

        $this->testService->validate(
            'resource_field',
            ['id' => 1],
            $this->createResourceField(
                createIfNotExists: true,
                required: true,
                allowNullIfIdentifierIsPresent: true,
            ),
        );
    }

    public function testItDoesNotPersistIfNotSetInFieldOptions(): void
    {
        $resourceTransformer = $this->expectResourceTransformerToBeReturned();
        $resourceTransformer->method('getEntityClass')->willReturn(ExampleEntity::class);

        $this->expectRepositoryToBeFound();

        $this->em->expects($this->never())->method('persist');

        $this->testService->validate(
            'resource_field',
            ['whatever' => 'value'],
            $this->createResourceField(
                createIfNotExists: true,
                required: true,
                persist: false,
            ),
        );
    }

    public function testItIsOfTypeResource(): void
    {
        $this->assertEquals(FieldType::RESOURCE, $this->testService->getType());
    }

    private function expectResourceTransformerToBeReturned(): ApiResourceTransformer&MockObject
    {
        $resourceTransformer = $this->createMock(ApiResourceTransformer::class);

        $this->apiResourceTransformerRegistry->expects($this->once())->method('get')->willReturn($resourceTransformer);

        return $resourceTransformer;
    }

    private function createResourceField(
        bool $createIfNotExists = false,
        bool $required = false,
        bool $persist = true,
        bool $allowNullIfIdentifierIsPresent = false,
    ): ResourceField {
        return new ResourceField(
            ExampleResource::class,
            $createIfNotExists,
            $required,
            persist: $persist,
            allowNullIfIdentifierIsPresent: $allowNullIfIdentifierIsPresent,
        );
    }

    private function expectRepositoryToBeFound(): MockObject
    {
        $repository = $this->createMock(EntityRepository::class);

        $this->em->expects($this->once())->method('getRepository')->willReturn($repository);

        return $repository;
    }
}
