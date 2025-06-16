<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Services\Validators;

use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\BoolField;
use Prescreen\ApiResourceBundle\Application\Enum\FieldType;
use Prescreen\ApiResourceBundle\Application\Services\Validators\BoolValidator;
use Prescreen\ApiResourceBundle\Exception\FieldTypeException;
use PHPUnit\Framework\TestCase;

class BoolValidatorTest extends TestCase
{
    private BoolValidator $testService;

    public function setUp(): void
    {
        $this->testService = new BoolValidator();
    }

    public function testItThrowsExceptionIfValueIsNotOfTypeBool(): void
    {
        $this->expectException(FieldTypeException::class);

        $this->testService->validate('someField', 'string value', new BoolField());
    }

    public function testItReturnsValueIfItIsOfTypeBool(): void
    {
        $this->assertTrue($this->testService->validate('someField', true, new BoolField()));
    }

    public function testItIsOfTypeBool(): void
    {
        $this->assertSame(FieldType::BOOL, $this->testService->getType());
    }
}
