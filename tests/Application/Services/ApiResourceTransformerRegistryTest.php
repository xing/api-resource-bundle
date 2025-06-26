<?php

namespace Prescreen\ApiResourceBundle\Tests\Application\Services;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\MockObject;
use Prescreen\ApiResourceBundle\Application\ApiResources\ExampleResource;
use Prescreen\ApiResourceBundle\Application\Configuration\FieldOptions\BoolField;
use Prescreen\ApiResourceBundle\Application\Services\ApiResourceTransformer;
use Prescreen\ApiResourceBundle\Application\Services\ApiResourceTransformerRegistry;
use PHPUnit\Framework\TestCase;

#[CoversClass(ApiResourceTransformerRegistry::class)]
class ApiResourceTransformerRegistryTest extends TestCase
{
    private iterable $apiResourceTransformers;
    private ApiResourceTransformerRegistry $testService;

    public function setUp(): void
    {
        $this->apiResourceTransformers = [
            $this->createInternalApiResourceTransformer(ExampleResource::class)
        ];
        $this->testService = new ApiResourceTransformerRegistry($this->apiResourceTransformers);
    }

    public function testItThrowsExceptionIfResourceTransformerForGivenResourceClassHasNotBeenRegistered(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->testService->get(BoolField::class);
    }

    public function testItReturnsResourceTransformerForGivenResourceClass(): void
    {
        $this->assertInstanceOf(ApiResourceTransformer::class, $this->testService->get(ExampleResource::class));
    }

    private function createInternalApiResourceTransformer(string $resourceClass): ApiResourceTransformer&MockObject
    {
        $resourceTransformer = $this->createMock(ApiResourceTransformer::class);
        $resourceTransformer->method('getResourceClass')->willReturn($resourceClass);

        return $resourceTransformer;
    }
}
