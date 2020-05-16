<?php

namespace Selective\Validation\Collector;

use Selective\Validation\ValidationResult;

/**
 * CakePHP validation error collector.
 */
final class CakeValidationErrorCollector implements ValidationErrorCollectorInterface
{
    /**
     * Create validation result from array with errors.
     *
     * @param array<mixed> $errors The validation errors
     * @param ValidationResult $result The result
     * @param string $path The path
     *
     * @return ValidationResult The result
     */
    public function addErrors(
        $errors,
        ValidationResult $result = null,
        string $path = ''
    ): ValidationResult {
        if ($result === null) {
            $result = new ValidationResult();
        }

        foreach ($errors as $field => $error) {
            $oldPath = $path;
            $path .= ($path === '' ? '' : '.') . $field;

            foreach ($error as $field2 => $errorMessage) {
                if (is_array($errorMessage)) {
                    $result = $this->addErrors([$field2 => $errorMessage], $result, $path);
                } else {
                    $result->addError($path, $errorMessage);
                }
            }

            $path = $oldPath;
        }

        return $result;
    }
}
