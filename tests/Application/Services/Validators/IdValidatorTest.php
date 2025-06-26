<?php

namespace Xing\ApiResourceBundle\Tests\Application\Services\Validators;

use Xing\ApiResourceBundle\Application\Enum\FieldType;
use Xing\ApiResourceBundle\Entity\ExampleEntity;
use Xing\ApiResourceBundle\Repository\ExampleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Xing\ApiResourceBundle\Application\Configuration\FieldOptions\IdField;
use Xing\ApiResourceBundle\Application\Configuration\FieldOptions\IntField;
use Xing\ApiResourceBundle\Application\Services\Validators\IdValidator;
use Xing\ApiResourceBundle\Exception\FieldTypeException;
use Xing\ApiResourceBundle\Exception\LinkedObjectNotFoundException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class IdValidatorTest extends TestCase
{
    protected EntityManagerInterface $em;
    private IdValidator $testService;

    public function setUp(): void
    {
        $this->em = $this->createMock(EntityManagerInterface::class);
        $this->testService = new IdValidator($this->em);
    }

    public function testItThrowsExceptionIfGivenFieldOptionsAreNotOfTypeIdField(): void
    {
        $this->expectException(FieldTypeException::class);

        $this->testService->validate('department_id', 1, new IntField());
    }

    public function testItThrowsExceptionIfEntityCannotBeFound(): void
    {
        $this->expectException(LinkedObjectNotFoundException::class);

        $repository = $this->expectRepositoryToBeFound();
        $repository->expects($this->once())->method('findOneBy')->willReturn(null);

        $this->testService->validate('example_id', 23502357, new IdField(ExampleEntity::class));
    }

    public function testItReturnsNullIfFieldIsNotRequiredAndValueIsNull(): void
    {
        $this->expectRepositoryToBeFound();

        $this->assertNull($this->testService->validate('example_id', null, new IdField(false)));
    }

    public function testItIsOfTypeId(): void
    {
        $this->assertSame(FieldType::ID, $this->testService->getType());
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
