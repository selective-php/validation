# Validation

[![Latest Version on Packagist](https://img.shields.io/github/release/odan/validation.svg)](https://github.com/odan/validation/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE.md)
[![Build Status](https://travis-ci.org/odan/validation.svg?branch=master)](https://travis-ci.org/odan/validation)
[![Quality Score](https://scrutinizer-ci.com/g/odan/validation/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/odan/validation/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/odan/validation.svg)](https://packagist.org/packages/odan/validation)


## Requirements

* PHP 7.1+

## Installation

```shell
composer require odan/validation
```

## Usage

Login example:

```php
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

### Slim Middleware

This validation middleware catches the `ValidationException` exception and converts it into a nice JSON response:

```php
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


[PSR-1]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md
[PSR-2]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md
[PSR-4]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md
[Composer]: http://getcomposer.org/
[PHPUnit]: http://phpunit.de/
