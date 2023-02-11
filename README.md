# tortitas/docker-sdk

## Install

Via Composer

```bash
composer require tortitas/docker-sdk
```

## Usage

```php
use Tortitas\DockerSDK\DockerSDK;
use Tortitas\DockerSDK\Container;

$image = 'nginx:latest';

DockerSDK::pull($image);

$container = new Container(
  'my-nginx-php-container', 
  $image
);

$container->create()->start();

DockerSDK::list();
```

### Notes
> If on Windows, you need to have Docker desktop installed and running. Also you need to have the Docker daemon running on TCP port 2375. You can do this by going to the Docker desktop settings and enabling the option "Expose daemon on tcp://localhost:2375 without TLS".

> The SDK uses the Docker API v1.41. You can check the API version by running `docker version` on your terminal.

## Testing

``` bash
composer test
```
