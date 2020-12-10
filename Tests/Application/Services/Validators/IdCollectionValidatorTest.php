<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Services\Validators;

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

class IdCollectionValidatorTest extends TestCase
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
     * @var IdCollectionValidator
     */
    private $testService;

    public function setUp(): void
    {
        $this->em = $this->createMock(EntityManagerInterface::class);
        $this->testService = new IdCollectionValidator($this->em);
    }

    /**
     * @test
     */
    public function givenFieldOptionsAreNotOfTypeIdFieldThenThrowException()
    {
        $this->expectException(FieldTypeException::class);

        $this->testService->validate('example_ids', [1], new IntField());
    }

    /**
     * @test
     */
    public function givenValueIsNotOfTypeArrayThenThrowException()
    {
        $this->expectException(FieldTypeException::class);

        $this->testService->validate('example_ids', 'foo', new IdCollectionField(ExampleEntity::class));
    }

    /**
     * @test
     */
    public function givenEntityCannotBeFoundThenThrowException()
    {
        $this->expectException(LinkedObjectNotFoundException::class);

        $repository = $this->expectRepositoryToBeFound();
        $repository->expects($this->once())->method('find')->willReturn(null);

        $this->testService->validate('example_ids', [23502357], new IdCollectionField(ExampleEntity::class));
    }

    /**
     * @test
     */
    public function givenFieldOptionsHaveRecruiterAccountThenFindEntitiesWithRecruiterAccountAndReturnThem()
    {
        $repository = $this->expectRepositoryToBeFound();
        $exampleEntity = new ExampleEntity();
        $repository->expects($this->exactly(2))->method('find')->willReturn($exampleEntity);

        $this->assertEquals(new ArrayCollection([$exampleEntity, $exampleEntity]), $this->testService->validate('example_ids', [1, 2], new IdCollectionField(ExampleEntity::class, true)));
    }

    /**
     * @test
     */
    public function givenFieldIsNotRequiredAndValueIsNullThenReturnNull()
    {
        $this->assertNull($this->testService->validate('example_ids', null, new IdCollectionField(ExampleEntity::class, false)));
    }

    /**
     * @test
     */
    public function itIsOfTypeIdCollection()
    {
        $this->assertSame(IdCollectionField::TYPE, $this->testService->getType());
    }

    /**
     * @return MockObject
     */
    private function expectRepositoryToBeFound(): MockObject
    {
        $repository = $this->createMock(ExampleRepository::class);

        $this->em->method('getRepository')->willReturn($repository);
        return $repository;
    }
}
