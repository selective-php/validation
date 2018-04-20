<?php

namespace Odan\Validation;

/**
 * Validation Message.
 *
 * Represents a container for the results of a validation request.
 */
class ValidationMessage
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
     * Get all errors.
     *
     * @return array Errors
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Get first error.
     *
     * @return mixed Error
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
     * Returns the success of the validation.
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
    public function failed(): bool
    {
        return !empty($this->errors);
    }

    /**
     * Clear errors and message.
     *
     * @return void
     */
    public function clear()
    {
        $this->message = null;
        $this->errors = [];
    }

    /**
     * Add error message.
     *
     * @param string $field the field name containing the error
     * @param string $message A String providing a short description of the error.
     * The message SHOULD be limited to a concise single sentence.
     * @param string|null $code A numeric or alphanumeric value that indicates the error type that occurred. (optional)
     *
     * @return void
     */
    public function addError(string $field, string $message, string $code = null)
    {
        if ($code === null) {
            $this->errors[] = ['field' => $field, 'message' => $message];
        } else {
            $this->errors[] = ['field' => $field, 'message' => $message, 'code' => $code];
        }
    }

    /**
     * Convert to array.
     *
     * @return array Data
     */
    public function toArray(): array
    {
        $result = [
            'success' => $this->success(),
        ];

        $message = $this->getMessage();
        if ($message !== null) {
            $result['message'] = $message;
        }

        if ($errors = $this->getErrors()) {
            $result['errors'] = $errors;
        }

        return $result;
    }
}
