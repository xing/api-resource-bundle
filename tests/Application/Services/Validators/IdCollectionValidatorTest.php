<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Services\Validators;

use PHPUnit\Framework\Attributes\CoversClass;
use Prescreen\ApiResourceBundle\Application\Enum\FieldType;
use Prescreen\ApiResourceBundle\Entity\ExampleEntity;
use Prescreen\ApiResourceBundle\Repository\ExampleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\IdCollectionField;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\IntField;
use Prescreen\ApiResourceBundle\Application\Services\Validators\IdCollectionValidator;
use Prescreen\ApiResourceBundle\Exception\FieldTypeException;
use Prescreen\ApiResourceBundle\Exception\LinkedObjectNotFoundException;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

#[CoversClass(IdCollectionValidator::class)]
class IdCollectionValidatorTest extends TestCase
{
    protected EntityManagerInterface $em;
    protected EntityRepository $repository;
    private IdCollectionValidator $testService;

    public function setUp(): void
    {
        $this->em = $this->createMock(EntityManagerInterface::class);
        $this->testService = new IdCollectionValidator($this->em);
    }

    public function testItThrowsExceptionIfGivenFieldOptionsAreNotOfTypeIdField(): void
    {
        $this->expectException(FieldTypeException::class);

        $this->testService->validate('example_ids', [1], new IntField());
    }

    public function testItThrowsExceptionIfValueIsNotOfTypeArray(): void
    {
        $this->expectException(FieldTypeException::class);

        $this->testService->validate('example_ids', 'foo', new IdCollectionField(ExampleEntity::class));
    }

    public function testItThrowsExceptionIfEntityCannotBeFound(): void
    {
        $this->expectException(LinkedObjectNotFoundException::class);

        $repository = $this->expectRepositoryToBeFound();
        $repository->expects($this->once())->method('findOneBy')->willReturn(null);

        $this->testService->validate('example_ids', [23502357], new IdCollectionField(ExampleEntity::class));
    }

    public function testItReturnsNullIfFieldIsNotRequiredAndValueIsNull(): void
    {
        $this->assertNull($this->testService->validate('example_ids', null, new IdCollectionField(ExampleEntity::class, false)));
    }

    public function testItIsOfTypeIdCollection(): void
    {
        $this->assertSame(FieldType::ID_COLLECTION, $this->testService->getType());
    }

    private function expectRepositoryToBeFound(): MockObject
    {
        $repository = $this->createMock(ExampleRepository::class);

        $this->em->method('getRepository')->willReturn($repository);
        return $repository;
    }
}
