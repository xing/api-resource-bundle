<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Services\Validators;

use Prescreen\ApiResourceBundle\Application\Services\Validators\ApiValidatorInterface;
use Prescreen\ApiResourceBundle\Application\Services\Validators\ApiValidatorRegistry;
use PHPUnit\Framework\TestCase;

class ApiValidatorRegistryTest extends TestCase
{
    private iterable $validators;
    private ApiValidatorRegistry $testService;

    public function setUp(): void
    {
        $validator1 = $this->createMock(ApiValidatorInterface::class);
        $validator1->method('getType')->willReturn('int');
        $validator2 = $this->createMock(ApiValidatorInterface::class);
        $validator2->method('getType')->willReturn('string');

        $this->validators = [$validator1, $validator2];
        $this->testService = new ApiValidatorRegistry($this->validators);
    }

    public function testItThrowsExceptionIfValidatorDoesNotExistForGivenType(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->testService->get('foo');
    }

    public function testItReturnsValidatorForGivenType(): void
    {
        $this->assertInstanceOf(ApiValidatorInterface::class, $this->testService->get('int'));
    }
}
