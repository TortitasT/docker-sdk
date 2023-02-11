<?php

namespace Tortitas\DockerSDK\Versions;

use Tortitas\DockerSDK\Container;
use Tortitas\DockerSDK\Helpers\Curl;
use Tortitas\DockerSDK\Versions\Version;

class Docker1dot41 implements Version
{
  public static function version(): array
  {
    $result = Curl::curl(
      'http://localhost/v1.41/version',
      'GET'
    );

    return $result;
  }

  public static function up(string $path): void
  {
    $command = 'docker-compose -f ' . $path . ' up -d';
    shell_exec($command);
  }

  public static function down(string $path): void
  {
    $command = 'docker-compose -f ' . $path . ' down';
    shell_exec($command);
  }

  public static function pull(string $image): void
  {
    Curl::curl(
      'http://localhost/v1.41/images/create?fromImage=' . $image . '',
      'POST'
    );
  }

  public static function list(): array
  {
    $result = Curl::curl(
      'http://localhost/v1.41/containers/json',
      'GET'
    );

    $containers = array_map(
      function ($item) {
        $container = new Container(
          substr($item['Names'][0], 1),
          $item['Image'],
          $item['Ports'],
          $item['HostConfig']
        );

        $container->id = $item['Id'];

        return $container;
      },
      $result
    );

    return $containers;
  }

  public static function create(Container $container): Container
  {
    $params = [
      'Image' => $container->image,
    ];

    if (!empty($container->exposedPorts)) {
      $params['ExposedPorts'] = $container->exposedPorts;
    }

    if (!empty($container->hostConfig)) {
      $params['HostConfig'] = $container->hostConfig;
    }

    $result = Curl::curl(
      'http://localhost/v1.41/containers/create?name=' . $container->name . '',
      'POST',
      $params
    );

    $container->id = $result['Id'];

    return $container;
  }

  public static function start(Container $container): Container
  {
    $result = Curl::curl(
      'http://localhost/v1.41/containers/' . $container->id . '/start',
      'POST'
    );

    return $container;
  }

  public static function stop(Container $container): Container
  {
    $result = Curl::curl(
      'http://localhost/v1.41/containers/' . $container->id . '/stop',
      'POST'
    );

    return $container;
  }

  public static function remove(Container $container): void
  {
    Curl::curl(
      'http://localhost/v1.41/containers/' . $container->id,
      'DELETE'
    );
  }
}
