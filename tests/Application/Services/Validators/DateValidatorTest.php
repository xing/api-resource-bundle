<?php

namespace Xing\ApiResourceBundle\Tests\Application\Services\Validators;

use Xing\ApiResourceBundle\Application\Configuration\FieldOptions\DateField;
use Xing\ApiResourceBundle\Application\Enum\FieldType;
use Xing\ApiResourceBundle\Application\Services\Validators\DateValidator;
use Xing\ApiResourceBundle\Exception\FieldTypeException;
use PHPUnit\Framework\TestCase;

class DateValidatorTest extends TestCase
{
    private DateValidator $testService;

    public function setUp(): void
    {
        $this->testService = new DateValidator();
    }

    public function testItThrowsExceptionIfValueCannotBeConvertedToDateTime(): void
    {
        $this->expectException(FieldTypeException::class);

        $this->testService->validate('date', 'some weird value', new DateField());
    }

    public function testItReturnsDateTimeIfValueCanBeConverted(): void
    {
        $this->assertInstanceOf(\DateTime::class, $this->testService->validate('date', '2020-03-27', new DateField()));
    }

    public function testItReturnsNullIfValueIsNullAndFieldIsNotRequired()
    {
        $this->assertNull($this->testService->validate('date', null, new DateField(false)));
    }

    public function testItIsOfTypeDate()
    {
        $this->assertSame(FieldType::DATE, $this->testService->getType());
    }
}
