<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Services\Validators;

use PHPUnit\Framework\TestCase;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\JsonField;
use Prescreen\ApiResourceBundle\Application\Services\Validators\JsonValidator;
use Prescreen\ApiResourceBundle\Exception\FieldTypeException;

class JsonValidatorTest extends TestCase
{
    /**
     * @var JsonValidator
     */
    private $testService;

    protected function setUp(): void
    {
        $this->testService = new JsonValidator();
    }

    /**
     * @test
     */
    public function givenValueIsNotOfTypeJsonThenThrowException()
    {
        $this->expectException(FieldTypeException::class);

        $this->testService->validate('json', false, new JsonField());
    }

    /**
     * @test
     */
    public function givenValidJsonValueThenReturnIt()
    {
        $this->assertSame(json_encode(['header' => 'Welcome']), $this->testService->validate('json', json_encode(['header' => 'Welcome']), new JsonField()));
    }

    /**
     * @test
     */
    public function givenValidArrayValueThenReturnIt()
    {
        $this->assertSame(['header' => 'Welcome'], $this->testService->validate('json', ['header' => 'Welcome'], new JsonField()));
    }

    /**
     * @test
     */
    public function givenFieldIsNotRequiredAndValueIsNullThenReturnNull()
    {
        $this->assertNull($this->testService->validate('json', null, new JsonField()));
    }

    /**
     * @test
     */
    public function itIsOfTypeString()
    {
        $this->assertSame(JsonField::TYPE, $this->testService->getType());
    }
}
