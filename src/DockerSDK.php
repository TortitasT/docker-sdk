<?php

namespace Tortitas\DockerSDK;

use Tortitas\DockerSDK\Helpers\Curl;

class DockerSDK
{
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

  public static function create(Container $container)
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

    return $result;
  }

  public static function start(Container $container)
  {
    $result = Curl::curl(
      'http://localhost/v1.41/containers/' . $container->id . '/start',
      'POST'
    );

    return $result;
  }

  public static function stop(Container $container)
  {
    $result = Curl::curl(
      'http://localhost/v1.41/containers/' . $container->id . '/stop',
      'POST'
    );

    return $result;
  }

  public static function remove(Container $container)
  {
    $result = Curl::curl(
      'http://localhost/v1.41/containers/' . $container->id,
      'DELETE'
    );

    return $result;
  }
}
