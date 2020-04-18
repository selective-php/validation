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
     * @var string|null
     */
    private $message;

    /**
     * @var string|null
     */
    private $code;

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
     * Get message.
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * Set the default success message.
     *
     * @param string $message The default success message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * Get the error code.
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Set the error code.
     *
     * @param string $code The error code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * Returns the success of the validation.
     *
     * @return bool true if validation was successful; otherwise, false
     */
    public function isSuccess(): bool
    {
        return empty($this->errors);
    }

    /**
     * Get validation failed status.
     *
     * @return bool Status
     */
    public function isFailed(): bool
    {
        return !$this->isSuccess();
    }

    /**
     * Clear errors and message.
     */
    public function clear(): void
    {
        $this->code = null;
        $this->message = null;
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
    public function addError(string $field, string $message, string $code = null): void
    {
        $error = new ValidationError($message);
        $error->setField($field)->setCode($code);

        $this->errors[] = $error;
    }

    /**
     * Add a validation error object.
     *
     * @param ValidationError $validationError The error object
     */
    public function addValidationError(ValidationError $validationError): void
    {
        $this->errors[] = $validationError;
    }
}
