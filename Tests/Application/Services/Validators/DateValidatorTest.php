<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Services\Validators;

use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\DateField;
use Prescreen\ApiResourceBundle\Application\Services\Validators\DateValidator;
use Prescreen\ApiResourceBundle\Exception\FieldTypeException;
use PHPUnit\Framework\TestCase;

class DateValidatorTest extends TestCase
{
    /**
     * @var DateValidator
     */
    private $testService;

    public function setUp(): void
    {
        $this->testService = new DateValidator();
    }

    /**
     * @test
     */
    public function givenValueCannotBeConvertedToDateTimeThenThrowException()
    {
        $this->expectException(FieldTypeException::class);

        $this->testService->validate('date', 'some weird value', new DateField());
    }

    /**
     * @test
     */
    public function givenValueCanBeConvertedToDateTimeThenReturnDateTime()
    {
        $this->assertInstanceOf(\DateTime::class, $this->testService->validate('date', '2020-03-27', new DateField()));
    }

    /**
     * @test
     */
    public function givenFieldIsNotRequiredAndValueIsNullThenReturnNull()
    {
        $this->assertNull($this->testService->validate('date', null, new DateField(false)));
    }

    /**
     * @test
     */
    public function itIsOfTypeDate()
    {
        $this->assertSame(DateField::TYPE, $this->testService->getType());
    }
}
