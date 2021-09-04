<?php

namespace Selective\Validation\Factory;

use Cake\Validation\Validator;
use Selective\Validation\Converter\CakeValidationConverter;
use Selective\Validation\ValidationResult;

/**
 * Cake Validation factory.
 */
final class CakeValidationFactory
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
     * Create validation result from array with errors.
     *
     * @param array $errors The errors
     *
     * @return ValidationResult The result
     */
    public function createValidationResult(array $errors): ValidationResult
    {
        return (new CakeValidationConverter())->createValidationResult($errors);
    }
}
