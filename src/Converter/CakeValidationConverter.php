<?php

namespace Selective\Validation\Converter;

use Selective\Validation\ValidationResult;

/**
 * CakePHP validation error convert.
 */
final class CakeValidationConverter
{
    /**
     * Create validation result from array with errors.
     *
     * @param array<mixed> $errors The validation errors
     *
     * @return ValidationResult The result
     */
    public static function createValidationResult(array $errors): ValidationResult
    {
        $result = new ValidationResult();

        static::addErrors($result, $errors);

        return $result;
    }

    /**
     * Add errors.
     *
     * @param ValidationResult $result The result
     * @param array<mixed> $errors The errors
     * @param string $path The path
     */
    private static function addErrors(ValidationResult $result, array $errors, string $path = ''): void
    {
        foreach ($errors as $field => $error) {
            $oldPath = $path;
            $path .= ($path === '' ? '' : '.') . $field;
            static::addSubErrors($result, $error, $path);
            $path = $oldPath;
        }
    }

    /**
     * Add sub errors.
     *
     * @param ValidationResult $result The result
     * @param array<mixed> $error The error
     * @param string $path The path
     */
    private static function addSubErrors(ValidationResult $result, array $error, string $path = ''): void
    {
        foreach ($error as $field2 => $errorMessage) {
            if (is_array($errorMessage)) {
                static::addErrors($result, [$field2 => $errorMessage], $path);
            } else {
                $result->addError($path, $errorMessage);
            }
        }
    }
}
