<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Services\Validators;

use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\IntField;
use Prescreen\ApiResourceBundle\Application\Services\Validators\IntValidator;
use Prescreen\ApiResourceBundle\Exception\FieldOutOfRangeException;
use Prescreen\ApiResourceBundle\Exception\FieldTypeException;
use PHPUnit\Framework\TestCase;

class IntValidatorTest extends TestCase
{
    /**
     * @var IntValidator
     */
    private $testService;

    public function setUp(): void
    {
        $this->testService = new IntValidator();
    }

    /**
     * @test
     */
    public function givenValueIsNotOfTypeIntThenThrowException()
    {
        $this->expectException(FieldTypeException::class);

        $this->testService->validate('int', 'string value', new IntField());
    }

    /**
     * @test
     */
    public function givenValueIsOutOfRangeThenThrowException()
    {
        $this->expectException(FieldOutOfRangeException::class);

        $this->testService->validate('int', 5000, new IntField(1, 5));
    }

    /**
     * @test
     */
    public function givenValidIntValueThenReturnIt()
    {
        $this->assertSame(1, $this->testService->validate('int', 1, new IntField(1, 5)));
    }

    /**
     * @test
     */
    public function givenFieldIsNotRequiredAndValueIsNullThenReturnNull()
    {
        $this->assertNull($this->testService->validate('int', null, new IntField()));
    }

    /**
     * @test
     */
    public function itIsOfTypeInt()
    {
        $this->assertSame(IntField::TYPE, $this->testService->getType());
    }
}
