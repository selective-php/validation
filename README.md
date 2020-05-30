# Validation

A validation library for PHP that uses the [notification pattern](https://martinfowler.com/articles/replaceThrowWithNotification.html).

[![Latest Version on Packagist](https://img.shields.io/github/release/selective-php/validation.svg)](https://packagist.org/packages/selective/validation)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE)
[![Build Status](https://github.com/selective-php/validation/workflows/build/badge.svg)](https://github.com/selective-php/validation/actions)
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

> A Notification collects together errors

In order to use a notification, you have to create the `ValidationResult` object. 
A `ValidationResult` can be really simple:

```php
<?php

use Selective\Validation\ValidationException;
use Selective\Validation\ValidationResult;

$validationResult = new ValidationResult();

if (empty($data['username'])) {
    $validationResult->addError('username', 'Input required');
}
```

You can now test the `ValidationResult` and throw an exception if it contains errors.

```php
<?php
if ($validationResult->isFailed()) {
    throw new ValidationException('Please check your input', $validationResult);
}
```

## Validating form data

Login example:

```php
<?php

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
    // Trigger error response (see validation middleware)
    throw new ValidationException('Please check your input', $validation);
}
```

### Validating JSON

Validating a JSON request works like validating form data, because in PHP it's just an array from the request object.

```php
<?php

// Fetch json data from request as array
$jsonData = (array)$request->getParsedBody();

$validation = new ValidationResult();

// ...

if ($validation->isFailed()) {
    throw new ValidationException('Please check your input', $validation);
}
```

In vanilla PHP you can fetch the JSON request as follows:

```php
<?php

$jsonData = (array)json_decode(file_get_contents('php://input'), true);

// ...
```

### Middleware

The `ValidationExceptionMiddleware` PSR-15 middleware catches all exceptions and converts 
it into a nice JSON response.

#### Slim 4 integration

Insert a container definition for `ValidationExceptionMiddleware::class`:

```php
<?php

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Selective\Validation\Encoder\JsonEncoder;
use Selective\Validation\Middleware\ValidationExceptionMiddleware;
use Selective\Validation\Transformer\ErrorDetailsResultTransformer;
use Slim\App;
use Slim\Factory\AppFactory;
// ...

return [
    ValidationExceptionMiddleware::class => static function (ContainerInterface $container) {
        $factory = $container->get(ResponseFactoryInterface::class);

        return new ValidationExceptionMiddleware(
            $factory, 
            new ErrorDetailsResultTransformer(), 
            new JsonEncoder()
        );
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

Add the `ValidationExceptionMiddleware` into your middlware stack:

```php
<?php

use Selective\Validation\Middleware\ValidationExceptionMiddleware;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

// ...

$app->add(ValidationExceptionMiddleware::class);

// ...

$app->run();
```

#### Usage

```php
<?php

use Selective\Validation\ValidationException;
use Selective\Validation\ValidationResult;

$validation = new ValidationResult();

// Validate username
if (empty($data->username)) {
    $validation->addError('username', 'Input required');
}

// Check validation result
if ($validation->isFailed()) {
    // Trigger the validation middleware
    throw new ValidationException('Please check your input', $validation);
}
```

## Transformer

If you want to implement a custom response data structure, 
you can implement a custom transformer against the 
`\Selective\Validation\Transformer\ResultTransformerInterface` interface.

**Example**

```php
<?php

namespace App\Transformer;

use Selective\Validation\Exception\ValidationException;
use Selective\Validation\Transformer\ResultTransformerInterface;
use Selective\Validation\ValidationResult;

final class MyValidationTransformer implements ResultTransformerInterface
{
    public function transform(
        ValidationResult $validationResult, 
        ValidationException $exception = null
    ): array {
        // Implement your own data structure for the response
        // ...

        return [];
    }
}
```

## Validator integration

You can combine this library with a validator that is doing the actual validation of your input data.

### Integration with CakePHP Validation 

The [cakephp/validation](https://github.com/cakephp/validation) library provides features to 
build validators that can validate arbitrary arrays of data with ease. 

The `$validator->errors()` method will return a non-empty array when there are validation failures. 
The returned array of errors then can be converted into a `ValidationResult` 
using the `CakeValidationErrorCollector`.

For example, if you wanted to validate a contact form before creating and sending 
an email you could do the following.

**Installation**

```
composer require cakephp/validation
```

**Usage**

```php
<?php

use Cake\Validation\Validator;
use Selective\Validation\Exception\ValidationException;
use Selective\Validation\Collector\CakeValidationErrorCollector;

// Note: This is just an example. Don't use the $request object within the domain layer.
$formData = (array)$request->getParsedBody();

// Basic form or json validation
$validator = new Validator();
$validator
    ->requirePresence('email')
    ->email('email', 'E-mail must be valid')
    ->requirePresence('name')
    ->notEmpty('name', 'We need your name.')
    ->requirePresence('comment')
    ->notEmpty('comment', 'You need to give a comment.');

$validationResult = (new CakeValidationErrorCollector)
    ->addErrors($validator->validate($formData));

// Optional: Do more complex validation and append it to the validation result
if (!$this->existsEmailInDatabase($formData['email'])) {
    $validationResult->addError('email', 'E-Mail already exists');
}

if ($validationResult->isFailed()) {
    throw new ValidationException('Validation failed. Please check your input.', $validationResult);
}
```

Instead of instantiating the `Validator` and `CakeValidationErrorCollector` yourself, you could use a factory like this

```php
<?php

namespace App\Validation;

use Cake\Validation\Validator;
use Selective\Validation\Collector\CakeValidationErrorCollector;
use Selective\Validation\Collector\ValidationErrorCollectorInterface;

final class ValidationFactory
{
    /**
     * Create validator.
     *
     * @return Validator The validator
     */
    public function createValidator(): Validator
    {
        return new Validator();
    }

    /**
     * Create a error collector.
     *
     * @return ValidationErrorCollectorInterface The error collector
     */
    public function createErrorCollector(): ValidationErrorCollectorInterface
    {
        return new CakeValidationErrorCollector();
    }
}
```

**Usage**

```php
<?php
$validator = $this->validationFactory->createValidator();

// ...

$validationResult = $this->validationFactory->createErrorCollector()
    ->addErrors($validator->validate($form));

if ($validationResult->isFailed()) {
   // ...
}
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
