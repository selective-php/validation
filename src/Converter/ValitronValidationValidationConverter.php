<?php

namespace Selective\Validation\Converter;

use Selective\Validation\ValidationResult;

/**
 * Valitron validation error collector.
 */
final class ValitronValidationValidationConverter implements ValidationConverterInterface
{
    /**
     * Create validation result from array with errors.
     *
     * @param array $errors The errors
     *
     * @return ValidationResult The result
     */
    public function createValidationResult($errors): ValidationResult
    {
        $result = new ValidationResult();

        $fields = [];

        foreach ($errors as $field => $message) {
            if (isset($fields[$field])) {
                continue;
            }

            $result->addError($field, $message);

            $fields[$field] = 1;
        }

        return $result;
    }
}
