<?php

namespace Xing\ApiResourceBundle\Tests\Application\Services\Validators;

use Xing\ApiResourceBundle\Application\Configuration\FieldOptions\BoolField;
use Xing\ApiResourceBundle\Application\Enum\FieldType;
use Xing\ApiResourceBundle\Application\Services\Validators\BoolValidator;
use Xing\ApiResourceBundle\Exception\FieldTypeException;
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
