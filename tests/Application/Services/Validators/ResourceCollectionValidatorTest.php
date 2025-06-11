<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Services\Validators;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Prescreen\ApiResourceBundle\Application\ApiResources\ExampleResource;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\ResourceCollectionField;
use Prescreen\ApiResourceBundle\Application\Services\ApiResourceTransformerRegistry;
use Prescreen\ApiResourceBundle\Application\Services\Validators\ResourceCollectionValidator;
use Prescreen\ApiResourceBundle\Entity\ExampleEntity;
use Prescreen\ApiResourceBundle\Exception\FieldTypeException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ResourceCollectionValidatorTest extends TestCase
{
    protected ApiResourceTransformerRegistry $apiResourceTransformerRegistry;
    protected EntityManagerInterface $em;
    private ResourceCollectionValidator $testService;

    public function setUp(): void
    {
        $this->apiResourceTransformerRegistry = $this->createMock(ApiResourceTransformerRegistry::class);
        $this->em = $this->createMock(EntityManagerInterface::class);
        $this->testService = new ResourceCollectionValidator($this->em, $this->apiResourceTransformerRegistry);
    }

    public function testItThrowsExceptionIfValueIsNotOfTypeArray(): void
    {
        $this->expectException(FieldTypeException::class);

        $this->testService->validate('resource_collection_field', 1, new ResourceCollectionField(ExampleResource::class));
    }

    public function testItReturnsArrayCollectionOfEntitiesIfValueIsArrayOfResources(): void
    {
        $repository = $this->expectRepositoryToBeFound();

        $repository->expects($this->exactly(2))->method('findOneBy')->willReturnOnConsecutiveCalls(
            new ExampleEntity(), new ExampleEntity()
        );

        $returnedCollection = $this->testService->validate('resource_collection_field', [['id' => 1], ['id' => 2]], new ResourceCollectionField(ExampleResource::class, true, true));

        $this->assertInstanceOf(ArrayCollection::class, $returnedCollection);
        $this->assertCount(2, $returnedCollection);
    }

    public function testItIsOfTypeResourceCollection(): void
    {
        $this->assertEquals(ResourceCollectionField::TYPE, $this->testService->getType());
    }

    private function expectRepositoryToBeFound(): MockObject
    {
        $repository = $this->createMock(EntityRepository::class);

        $this->em->method('getRepository')->willReturn($repository);

        return $repository;
    }
}
