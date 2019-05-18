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

// Get all POST values
$data = $request->getParsedBody();

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

### Slim 3 Middleware

This validation middleware catches the `ValidationException` exception and converts it into a nice JSON response:

```php
use Selective\Validation\ValidationException;

// Validation middleware
$app->add(function (Request $request, Response $response, $next) {
    try{
        return $next($request, $response);
    } catch (ValidationException $exception) {
        return $response->withStatus(422)->withJson(['error' => $exception->getValidation()->toArray()]);
    }
});
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
