<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Services\Validators;

use PHPUnit\Framework\TestCase;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\JsonField;
use Prescreen\ApiResourceBundle\Application\Services\Validators\JsonValidator;
use Prescreen\ApiResourceBundle\Exception\FieldTypeException;

class JsonValidatorTest extends TestCase
{
    private JsonValidator $testService;

    protected function setUp(): void
    {
        $this->testService = new JsonValidator();
    }

    public function testItThrowsExceptionIfValueIsNotOfTypeJson(): void
    {
        $this->expectException(FieldTypeException::class);

        $this->testService->validate('json', false, new JsonField());
    }

    public function testItReturnsValueIfJsonIsValid(): void
    {
        $this->assertSame(json_encode(['header' => 'Welcome']), $this->testService->validate('json', json_encode(['header' => 'Welcome']), new JsonField()));
    }

    public function testItReturnsValueIfGivenAValidArray(): void
    {
        $this->assertSame(['header' => 'Welcome'], $this->testService->validate('json', ['header' => 'Welcome'], new JsonField()));
    }

    public function testItReturnsNullIfFieldIsNotRequiredAndValueIsNull(): void
    {
        $this->assertNull($this->testService->validate('json', null, new JsonField()));
    }

    public function testItIsOfTypeString(): void
    {
        $this->assertSame(JsonField::TYPE, $this->testService->getType());
    }
}
