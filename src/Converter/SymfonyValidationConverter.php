<?php

namespace Selective\Validation\Converter;

use Selective\Validation\ValidationResult;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * Symfony validation error collector.
 */
final class SymfonyValidationConverter
{
    /**
     * Create validation result from array with errors.
     *
     * @param ConstraintViolationList $violations The validation errors
     *
     * @return ValidationResult The result
     */
    public static function createValidationResult(
        ConstraintViolationList $violations
    ): ValidationResult {
        $result = new ValidationResult();

        /** @var ConstraintViolation $violation */
        foreach ($violations as $violation) {
            $field = $violation->getPropertyPath();
            $field = str_replace(']', '', str_replace('[', '', str_replace('][', '.', $field)));
            $result->addError($field, $violation->getMessage());
        }

        return $result;
    }
}
