<?php

namespace Selective\Validation\Converter;

use Selective\Validation\ValidationResult;

/**
 * Converter interface.
 */
interface ValidationConverterInterface
{
    /**
     * Create validation result from array with errors.
     *
     * @param mixed $errors The constraint violations to add to the list
     *
     * @return ValidationResult The result
     */
    public function createValidationResult($errors): ValidationResult;
}
