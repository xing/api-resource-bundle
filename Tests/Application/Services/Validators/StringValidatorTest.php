<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Services\Validators;

use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\StringField;
use Prescreen\ApiResourceBundle\Application\Services\Validators\StringValidator;
use Prescreen\ApiResourceBundle\Exception\FieldTypeException;
use PHPUnit\Framework\TestCase;

class StringValidatorTest extends TestCase
{
    private StringValidator $testService;

    public function setUp(): void
    {
        $this->testService = new StringValidator();
    }

    public function testItThrowsExceptionIfValueIsNotOfTypeString(): void
    {
        $this->expectException(FieldTypeException::class);

        $this->testService->validate('string', false, new StringField());
    }

    public function testItReturnsValueIfGivenValidString(): void
    {
        $this->assertSame('Some value', $this->testService->validate('string', 'Some value', new StringField()));
    }

    public function testItReturnsNullIfFieldIsNotRequiredAndValueIsNull(): void
    {
        $this->assertNull($this->testService->validate('string', null, new StringField()));
    }

    public function testItIsOfTypeString(): void
    {
        $this->assertSame(StringField::TYPE, $this->testService->getType());
    }
}
