# Validation

[![Latest Version on Packagist](https://img.shields.io/github/release/selective-php/validation.svg)](https://packagist.org/packages/selective/validation)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE.md)
[![Build Status](https://travis-ci.org/selective-php/validation.svg?branch=master)](https://travis-ci.org/selective-php/validation)
[![Coverage Status](https://scrutinizer-ci.com/g/selective-php/validation/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/selective-php/validation/code-structure)
[![Quality Score](https://scrutinizer-ci.com/g/selective-php/validation/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/selective-php/validation/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/selective/validation.svg)](https://packagist.org/packages/selective/validation/stats)

## Requirements

* PHP 7.1+

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

The `ValidationExceptionMiddleware` PSR-15 middleware catches all exceptions and converts it into a nice JSON response.

#### Slim 4 integration

```php
<?php

use Selective\Validation\Middleware\ValidationExceptionMiddleware;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->add(ValidationExceptionMiddleware::class); // <--- add middleware

// ...

$app->run();
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

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
