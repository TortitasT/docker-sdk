<?php

namespace Tortitas\DockerSDK\Test;

use PHPUnit\Framework\TestCase;
use Tortitas\DockerSDK\DockerSDK;

class DockerSDKTest extends TestCase
{
  public function testList()
  {
    $sdk = new DockerSDK();

    $this->assertEquals([], $sdk->list());
  }
}
