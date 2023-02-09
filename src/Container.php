<?php

namespace Tortitas\DockerSDK;

use stdClass;

class Container
{
  public string $id;
  public string $metadata;

  public function __construct(
    public string $name,
    public string $image,
    public array $exposedPorts = [],
    public array $hostConfig = [],
  ) {
  }


  public function create(): Container
  {
    DockerSDK::create($this);

    return $this;
  }

  public function start(): Container
  {
    DockerSDK::start($this);

    return $this;
  }

  public function stop(): Container
  {
    DockerSDK::stop($this);

    return $this;
  }

  public function remove(): void
  {
    DockerSDK::remove($this);
  }
}
