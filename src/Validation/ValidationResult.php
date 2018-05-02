<?php

namespace Odan\Validation;

use JsonSerializable;

/**
 * Validation Result.
 *
 * Represents a container for the results of a validation request.
 *
 * A validation result collects together errors and messages.
 *
 * https://martinfowler.com/articles/replaceThrowWithNotification.html
 */
class ValidationResult implements JsonSerializable
{
    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @var string|null
     */
    protected $message = null;

    /**
     * @var string|null
     */
    protected $code = null;

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
    public function getFirstError()
    {
        return reset($this->errors);
    }

    /**
     * Get message.
     *
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * Set the default success message.
     *
     * @param string $message The default success message
     *
     * @return void
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    /**
     * Get the error code.
     *
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Set the error code.
     *
     * @param string $message The error code
     *
     * @return void
     */
    public function setCode(string $message)
    {
        $this->code = $message;
    }

    /**
     * Returns the success of the validation.
     *
     * @return bool true if validation was successful; otherwise, false
     */
    public function isSuccess(): bool
    {
        return empty($this->errors) && $this->message === null && $this->code === null;
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
     *
     * @return void
     */
    public function clear()
    {
        $this->code = null;
        $this->message = null;
        $this->errors = [];
    }

    /**
     * Add error message.
     *
     * @param string $field the field name containing the error
     * @param string $message a String providing a short description of the error.
     * The message SHOULD be limited to a concise single sentence
     * @param string|null $code A numeric or alphanumeric value that indicates the error type that occurred. (optional)
     *
     * @return void
     */
    public function addError(string $field, string $message, string $code = null)
    {
        $message = new ValidationError($message);
        $message->setField($field)->setCode($code);

        $this->errors[] = $message;
    }

    /**
     * Add a validation error object.
     *
     * @param ValidationError $validationError The error object
     *
     * @return void
     */
    public function addValidationError(ValidationError $validationError)
    {
        $this->errors[] = $validationError;
    }

    /**
     * Convert to array.
     *
     * @return array Data
     */
    public function toArray(): array
    {
        $result = [];

        $code = $this->getCode();
        if ($code !== null) {
            $result['code'] = $code;
        }

        $message = $this->getMessage();
        if ($message !== null) {
            $result['message'] = $message;
        }

        if (!empty($errors = $this->getErrors())) {
            $result['errors'] = [];
            foreach ($errors as $error) {
                $result['errors'][] = $error->toArray();
            }
        }

        return $result;
    }

    /**
     * Serializes the object to a value that can be serialized natively by json_encode().
     *
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
