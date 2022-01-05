<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Services\Validators;

use Prescreen\ApiResourceBundle\Entity\ExampleEntity;
use Prescreen\ApiResourceBundle\Repository\ExampleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\IdField;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\IntField;
use Prescreen\ApiResourceBundle\Application\Services\Validators\IdValidator;
use Prescreen\ApiResourceBundle\Exception\FieldTypeException;
use Prescreen\ApiResourceBundle\Exception\LinkedObjectNotFoundException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class IdValidatorTest extends TestCase
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;
    /**
     * @var IdValidator
     */
    private $testService;

    public function setUp(): void
    {
        $this->em = $this->createMock(EntityManagerInterface::class);
        $this->testService = new IdValidator($this->em);
    }

    /**
     * @test
     */
    public function givenFieldOptionsAreNotOfTypeIdFieldThenThrowException()
    {
        $this->expectException(FieldTypeException::class);

        $this->testService->validate('department_id', 1, new IntField());
    }

    /**
     * @test
     */
    public function givenValueIsNotOfTypeIntThenThrowException()
    {
        $this->expectException(FieldTypeException::class);

        $this->testService->validate('example_id', 'foo', new IdField(ExampleEntity::class));
    }

    /**
     * @test
     */
    public function givenEntityCannotBeFoundThenThrowException()
    {
        $this->expectException(LinkedObjectNotFoundException::class);

        $repository = $this->expectRepositoryToBeFound();
        $repository->expects($this->once())->method('findOneBy')->willReturn(null);

        $this->testService->validate('example_id', 23502357, new IdField(ExampleEntity::class));
    }

    /**
     * @test
     */
    public function givenFieldOptionsHaveRecruiterAccountThenFindEntityWithRecruiterAccountAndReturnIt()
    {
        $repository = $this->expectRepositoryToBeFound();
        $exampleEntity = new ExampleEntity();
        $repository->expects($this->once())->method('findOneBy')->willReturn($exampleEntity);

        $this->assertEquals($exampleEntity, $this->testService->validate('example_id', 23502357, new IdField(ExampleEntity::class, true)));
    }

    /**
     * @test
     */
    public function givenFieldOptionsDoNotHaveRecruiterAccountThenFindEntityAndReturnIt()
    {
        $repository = $this->expectRepositoryToBeFound();
        $department = new ExampleEntity();
        $repository->expects($this->once())->method('findOneBy')->willReturn($department);

        $this->assertEquals($department, $this->testService->validate('example_id', 23502357, new IdField(ExampleEntity::class)));
    }

    /**
     * @test
     */
    public function givenFieldIsNotRequiredAndValueIsNullThenReturnNull()
    {
        $this->assertNull($this->testService->validate('example_id', null, new IdField(false)));
    }

    /**
     * @test
     */
    public function itIsOfTypeId()
    {
        $this->assertSame(IdField::TYPE, $this->testService->getType());
    }

    /**
     * @return MockObject
     */
    private function expectRepositoryToBeFound(): MockObject
    {
        $repository = $this->createMock(ExampleRepository::class);

        $this->em->expects($this->once())->method('getRepository')->willReturn($repository);
        return $repository;
    }
}
