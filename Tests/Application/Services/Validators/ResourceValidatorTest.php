<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Services\Validators;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Prescreen\ApiResourceBundle\Application\ApiResources\ExampleResource;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\IdField;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\ResourceField;
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
    /**
     * @var ApiResourceTransformerRegistry
     */
    protected $apiResourceTransformerRegistry;
    /**
     * @var EntityManagerInterface
     */
    protected $em;
    /**
     * @var ResourceValidator
     */
    private $testService;

    public function setUp(): void
    {
        $this->apiResourceTransformerRegistry = $this->createMock(ApiResourceTransformerRegistry::class);
        $this->em = $this->createMock(EntityManagerInterface::class);
        $this->testService = new ResourceValidator($this->em, $this->apiResourceTransformerRegistry);
    }

    /**
     * @test
     */
    public function givenFieldOptionsAreNotOfTypeResourceFieldThenThrowException()
    {
        $this->expectException(FieldTypeException::class);

        $this->testService->validate('resource_field', null, new IdField(ExampleEntity::class));
    }

    /**
     * @test
     */
    public function givenResourceTransformerForResourceHasNotBeenRegisteredThenThrowException()
    {
        $this->expectException(MissingResourceTransformerException::class);

        $this->apiResourceTransformerRegistry->expects($this->once())->method('get')->willThrowException(new \InvalidArgumentException());

        $this->testService->validate('resource_field', null, new ResourceField(ExampleResource::class));
    }

    /**
     * @test
     */
    public function givenValueIsNotOfTypeArrayThenThrowException()
    {
        $this->expectException(FieldTypeException::class);

        $this->expectResourceTransformerToBeReturned();

        $this->testService->validate('resource_field', 1, $this->createResourceField(false, true));
    }

    /**
     * @test
     */
    public function givenEntityIsNullButFieldIsRequiredThenThrowException()
    {
        $this->expectException(RequiredFieldMissingException::class);

        $this->expectResourceTransformerToBeReturned();

        $this->testService->validate('resource_field', ['foo' => 1], $this->createResourceField(false, true));
    }

    /**
     * @test
     */
    public function givenNoIdAndResourceShouldNotBeCreatedButFieldIsRequiredThenThrowException()
    {
        $this->expectException(RequiredFieldMissingException::class);

        $this->expectResourceTransformerToBeReturned();

        $this->testService->validate('resource_field', ['foo' => 1], $this->createResourceField(false, true));
    }

    /**
     * @test
     */
    public function givenIdThenGetEntityFromRepository()
    {
        $resourceTransformer = $this->expectResourceTransformerToBeReturned();
        $resourceTransformer->method('getEntityClass')->willReturn(ExampleEntity::class);
        $resourceTransformer->expects($this->once())->method('fromArray');

        $repository = $this->expectRepositoryToBeFound();
        $exampleEntity = new ExampleEntity();
        $repository->expects($this->once())->method('find')->willReturn($exampleEntity);

        $fieldOptions = $this->createResourceField(false, true);

        $this->testService->validate('resource_field', ['id' => 1], $fieldOptions);
    }

    /**
     * @test
     */
    public function givenNoIdAndCreateIfNotExistsThenCreateNewEntityFromResource()
    {
        $resourceTransformer = $this->expectResourceTransformerToBeReturned();
        $resourceTransformer->method('getEntityClass')->willReturn(ExampleEntity::class);

        $fieldOptions = $this->createResourceField(true, true);

        $this->em->expects($this->once())->method('persist');

        $returnedEntity = $this->testService->validate('resource_field', ['foo' => 'bar'], $fieldOptions);

        $this->assertInstanceOf(ExampleEntity::class, $returnedEntity);
    }

    /**
     * @test
     */
    public function givenNoIdAndNoCreateIfNotExistsAndFieldIsNotRequiredThenReturnNull()
    {
        $this->expectResourceTransformerToBeReturned();

        $this->assertNull($this->testService->validate('resource_field', ['foo' => 'bar'], $this->createResourceField(false, false)));
    }

    /**
     * @test
     */
    public function givenValueIsNullAndFieldIsNotRequiredThenReturnNull()
    {
        $this->expectResourceTransformerToBeReturned();

        $this->assertNull($this->testService->validate('resource_field', null, $this->createResourceField(false, false)));
    }

    /**
     * @test
     */
    public function itIsOfTypeResource()
    {
        $this->assertEquals(ResourceField::TYPE, $this->testService->getType());
    }

    /**
     * @return ApiResourceTransformer
     */
    private function expectResourceTransformerToBeReturned(): ApiResourceTransformer
    {
        $resourceTransformer = $this->createMock(ApiResourceTransformer::class);

        $this->apiResourceTransformerRegistry->expects($this->once())->method('get')->willReturn($resourceTransformer);

        return $resourceTransformer;
    }

    /**
     * @param bool $createIfNotExists
     * @param bool $required
     *
     * @return ResourceField
     */
    private function createResourceField(bool $createIfNotExists = false, bool $required = false): ResourceField
    {
        return new ResourceField(ExampleResource::class, $createIfNotExists, $required);
    }

    /**
     * @return MockObject
     */
    private function expectRepositoryToBeFound(): MockObject
    {
        $repository = $this->createMock(EntityRepository::class);

        $this->em->expects($this->once())->method('getRepository')->willReturn($repository);

        return $repository;
    }
}
