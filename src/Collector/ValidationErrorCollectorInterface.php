<?php

namespace Selective\Validation\Collector;

use Selective\Validation\ValidationResult;

/**
 * Validation Error Collector Interface.
 */
interface ValidationErrorCollectorInterface
{
    /**
     * Convert errors into a ValidationResult with errors.
     *
     * @param mixed $errors The errors
     * @param ValidationResult|null $validationResult Append error to existing ValidationResult
     *
     * @return ValidationResult The result
     */
    public function addErrors(
        $errors,
        ValidationResult $validationResult = null
    ): ValidationResult;
}
