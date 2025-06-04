<?php

namespace Selective\Validation;

/**
 * Validation Result.
 *
 * Represents a container for the results of a validation request.
 *
 * A validation result collects together errors and messages.
 *
 * https://martinfowler.com/articles/replaceThrowWithNotification.html
 */
final class ValidationResult
{
    /**
     * @var ValidationError[]
     */
    private $errors = [];

    /**
     * Get all errors.
     *
     * @return ValidationError[] Errors
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Get first error.
     *
     * @return ValidationError|null Error message
     */
    public function getFirstError(): ?ValidationError
    {
        return reset($this->errors) ?: null;
    }

    /**
     * Determine if the data passes the validation rules.
     *
     * @return bool true if validation was successful; otherwise, false
     */
    public function success(): bool
    {
        return empty($this->errors);
    }

    /**
     * Get validation failed status.
     *
     * @return bool Status
     */
    public function fails(): bool
    {
        return !$this->success();
    }

    /**
     * Clear errors and message.
     */
    public function clear(): void
    {
        $this->errors = [];
    }

    /**
     * Add error message.
     *
     * @param string $field The field name containing the error
     * @param string $message A String providing a short description of the error.
     * The message SHOULD be limited to a concise single sentence
     * @param string|null $code A numeric or alphanumeric value that indicates the error type that occurred. (optional)
     */
    public function addError(string $field, string $message, ?string $code = null): void
    {
        $error = new ValidationError($message);
        $error->setField($field)->setCode($code);

        $this->errors[] = $error;
    }
}
