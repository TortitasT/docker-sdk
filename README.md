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

new Container(
  'my-nginx-php-container', 
  $image
  )
  ->create()
  ->start();

DockerSDK::list();
```

## Testing

``` bash
composer test
```
