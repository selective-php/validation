# Validation

[![Latest Version on Packagist](https://img.shields.io/github/release/selective-php/validation.svg)](https://packagist.org/packages/selective/validation)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE)
[![Build Status](https://github.com/selective-php/validation/workflows/PHP/badge.svg)](https://github.com/selective-php/validation/actions)
[![Coverage Status](https://scrutinizer-ci.com/g/selective-php/validation/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/selective-php/validation/code-structure)
[![Quality Score](https://scrutinizer-ci.com/g/selective-php/validation/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/selective-php/validation/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/selective/validation.svg)](https://packagist.org/packages/selective/validation/stats)

## Requirements

* PHP 7.2+

## Installation

```shell
composer require selective/validation
```

## Usage

Login example:

```php
use Selective\Validation\ValidationException;
use Selective\Validation\ValidationResult;

// ...

// Get all POST values
$data = (array)$request->getParsedBody();

$validation = new ValidationResult();

// Validate username
if (empty($data['username'])) {
    $validation->addError('username', 'Input required');
}

// Validate password
if (empty($data['password'])) {
    $validation->addError('password', 'Input required');
}

// Check validation result
if ($validation->isFailed()) {
    // Global error message
    $validation->setMessage('Please check your input');

    // Trigger error response (see validation middleware)
    throw new ValidationException($validation);
}
```

### Middleware

The `ValidationExceptionMiddleware` PSR-15 middleware catches all exceptions and converts 
it into a nice JSON response.

#### Slim 4 integration

```php
<?php

use Selective\Validation\Encoder\JsonEncoder;
use Selective\Validation\Middleware\ValidationExceptionMiddleware;
use Selective\Validation\Transformer\ErrorDetailsTransformer;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->add(new ValidationExceptionMiddleware(
    $app->getResponseFactory(),
    new ErrorDetailsTransformer(),
    new JsonEncoder()
));

// If you are using a container, you can also use this option:
// $app->add(ValidationExceptionMiddleware::class);

// ...

$app->run();
```

### Container definition

This example uses PHI-DI:

```php
<?php

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Selective\Validation\Encoder\JsonEncoder;
use Selective\Validation\Middleware\ValidationExceptionMiddleware;
use Selective\Validation\Transformer\ErrorDetailsTransformer;
use Slim\App;
use Slim\Factory\AppFactory;
// ...

return [
    ValidationExceptionMiddleware::class => static function (ContainerInterface $container) {
        $factory = $container->get(ResponseFactoryInterface::class);

        return new ValidationExceptionMiddleware($factory, new ErrorDetailsTransformer(), new JsonEncoder());
    },

    ResponseFactoryInterface::class => static function (ContainerInterface $container) {
        $app = $container->get(App::class);

        return $app->getResponseFactory();
    },

    App::class => static function (ContainerInterface $container) {
        AppFactory::setContainer($container);

        return AppFactory::create();
    },

    // ...

];
```

#### Usage

```php
use Selective\Validation\ValidationException;
use Selective\Validation\ValidationResult;

$validation = new ValidationResult();

// Validate username
if (empty($data->username)) {
    $validation->addError('username', 'Input required');
}

// Check validation result
if ($validation->isFailed()) {
    $validation->setMessage('Please check your input');

    // Trigger the validation middleware
    throw new ValidationException($validation);
}
```

## Transformer

If you want to implement a custom response data structure, 
you can implement against the `\Selective\Validation\Transformer\TransformerInterface` interface.

**Example**
```
<?php

namespace App\Transformer;

use Selective\Validation\ValidationResult;

final class MyValidationTransformer implements TransformerInterface
{
    public function transform(ValidationResult $validationResult): array
    {
        // Implement your own data structure for the response
        // ...

        return [];
    }
}
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
