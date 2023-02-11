<?php

namespace Tortitas\DockerSDK\Test;

use function PHPUnit\Framework\assertEquals;

use PHPUnit\Framework\TestCase;
use Tortitas\DockerSDK\Container;

use Tortitas\DockerSDK\DockerSDK;

class DockerSDKTest extends TestCase
{
    public function testFunctional(): void
    {
        $image = "docker/getting-started";

        DockerSDK::pull($image);

        $container = new Container(
            'php-docker-sdk-test',
            $image,
        );

        $container
            ->create()
            ->start();

        $foundContainer = array_filter(
            DockerSDK::list(),
            fn ($item) => $item->name === $container->name,
        );

        assertEquals(1, count($foundContainer));

        $container
            ->stop()
            ->remove();
    }

    public function testVersion(): void
    {
        $version = DockerSDK::version();

        assertEquals('1.41', $version['ApiVersion']);
    }
}
