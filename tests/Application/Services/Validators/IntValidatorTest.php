<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Services\Validators;

use PHPUnit\Framework\Attributes\CoversClass;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\IntField;
use Prescreen\ApiResourceBundle\Application\Enum\FieldType;
use Prescreen\ApiResourceBundle\Application\Services\Validators\IntValidator;
use Prescreen\ApiResourceBundle\Exception\FieldOutOfRangeException;
use Prescreen\ApiResourceBundle\Exception\FieldTypeException;
use PHPUnit\Framework\TestCase;

#[CoversClass(IntValidator::class)]
class IntValidatorTest extends TestCase
{
    private IntValidator $testService;

    public function setUp(): void
    {
        $this->testService = new IntValidator();
    }

    public function testItThrowsExceptionIfValueIsNotOfTypeInt(): void
    {
        $this->expectException(FieldTypeException::class);

        $this->testService->validate('int', 'string value', new IntField());
    }

    public function testItThrowsExceptionIfValueIsOutOfRange(): void
    {
        $this->expectException(FieldOutOfRangeException::class);

        $this->testService->validate('int', 5000, new IntField(1, 5));
    }

    public function testItReturnsValueIfItIsValidInt(): void
    {
        $this->assertSame(1, $this->testService->validate('int', 1, new IntField(1, 5)));
    }

    public function testItReturnsNullIfFieldIsNotRequiredAndValueIsNull(): void
    {
        $this->assertNull($this->testService->validate('int', null, new IntField()));
    }

    public function testItIsOfTypeInt(): void
    {
        $this->assertSame(FieldType::INT, $this->testService->getType());
    }
}
