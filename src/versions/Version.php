<?php

namespace Tortitas\DockerSDK\Versions;

use Tortitas\DockerSDK\Container;

interface Version
{
  public static function version(): array;
  public static function up(string $path): void;
  public static function down(string $path): void;
  public static function pull(string $image): void;
  public static function list(): array;
  public static function create(Container $container): Container;
  public static function start(Container $container): Container;
  public static function stop(Container $container): Container;
  public static function remove(Container $container): void;
}
