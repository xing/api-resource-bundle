<?php

namespace Xing\ApiResourceBundle\Tests\Application\Services\Validators;

use Xing\ApiResourceBundle\Application\Configuration\FieldOptions\IntField;
use Xing\ApiResourceBundle\Application\Enum\FieldType;
use Xing\ApiResourceBundle\Application\Services\Validators\IntValidator;
use Xing\ApiResourceBundle\Exception\FieldOutOfRangeException;
use Xing\ApiResourceBundle\Exception\FieldTypeException;
use PHPUnit\Framework\TestCase;

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
