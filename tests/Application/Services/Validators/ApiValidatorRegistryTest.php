<?php

namespace Xing\ApiResourceBundle\Tests\Application\Services\Validators;

use Xing\ApiResourceBundle\Application\Enum\FieldType;
use Xing\ApiResourceBundle\Application\Services\Validators\ApiValidatorInterface;
use Xing\ApiResourceBundle\Application\Services\Validators\ApiValidatorRegistry;
use PHPUnit\Framework\TestCase;

class ApiValidatorRegistryTest extends TestCase
{
    private iterable $validators;
    private ApiValidatorRegistry $testService;

    public function setUp(): void
    {
        $validator1 = $this->createMock(ApiValidatorInterface::class);
        $validator1->method('getType')->willReturn(FieldType::INT);
        $validator2 = $this->createMock(ApiValidatorInterface::class);
        $validator2->method('getType')->willReturn(FieldType::STRING);

        $this->validators = [$validator1, $validator2];
        $this->testService = new ApiValidatorRegistry($this->validators);
    }

    public function testItThrowsExceptionIfValidatorDoesNotExistForGivenType(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->testService->get(FieldType::DATE);
    }

    public function testItReturnsValidatorForGivenType(): void
    {
        $this->assertInstanceOf(ApiValidatorInterface::class, $this->testService->get(FieldType::INT));
    }
}
