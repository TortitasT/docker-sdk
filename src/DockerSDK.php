<?php

namespace Tortitas\DockerSDK;

use Tortitas\DockerSDK\Helpers\Curl;
use Tortitas\DockerSDK\Versions\Docker1dot41;

class DockerSDK
{
    public static $version = Docker1dot41::class;

    public static function __callStatic($name, $arguments)
    {
        return self::$version::$name(...$arguments);
    }
}
