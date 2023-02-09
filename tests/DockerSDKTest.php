<?php

namespace Tortitas\DockerSDK\Test;

use PHPUnit\Framework\TestCase;
use Tortitas\DockerSDK\Container;
use Tortitas\DockerSDK\DockerSDK;

use function PHPUnit\Framework\assertEquals;

class DockerSDKTest extends TestCase
{
  public function testFunctional(): void
  {
    $image = "docker/getting-started";

    DockerSDK::pull($image);

    $container = new Container(
      'php-docker-sdk-test',
      $image,
      // ['80/tcp' => new \stdClass(),],
      // [
      //   'PortBindings' => [
      //     '80/tcp' => [
      //       ['HostPort' => '80',],
      //     ],
      //   ],
      // ],
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
}
