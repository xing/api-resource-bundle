<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Services\Validators;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use Prescreen\ApiResourceBundle\Application\ApiResources\ExampleResource;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\BoolField;
use Prescreen\ApiResourceBundle\Application\Enum\FieldType;
use Prescreen\ApiResourceBundle\Application\Services\Validators\BoolValidator;
use Prescreen\ApiResourceBundle\Exception\ApiValidatorException;
use Prescreen\ApiResourceBundle\Exception\FieldTypeException;
use PHPUnit\Framework\TestCase;

#[CoversClass(BoolValidator::class)]
#[CoversClass(BoolField::class)]
#[UsesClass(ApiValidatorException::class)]
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
