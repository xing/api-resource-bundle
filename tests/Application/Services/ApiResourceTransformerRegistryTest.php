<?php

namespace Xing\ApiResourceBundle\Tests\Application\Services;

use PHPUnit\Framework\MockObject\MockObject;
use Xing\ApiResourceBundle\Application\ApiResources\ExampleResource;
use Xing\ApiResourceBundle\Application\Configuration\FieldOptions\BoolField;
use Xing\ApiResourceBundle\Application\Services\ApiResourceTransformer;
use Xing\ApiResourceBundle\Application\Services\ApiResourceTransformerRegistry;
use PHPUnit\Framework\TestCase;

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
