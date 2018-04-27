<?php

namespace Odan\Validation;

/**
 * Validation Result.
 *
 * Represents a container for the results of a validation request.
 *
 * A validation result collects together errors and messages.
 *
 * https://martinfowler.com/articles/replaceThrowWithNotification.html
 */
class ValidationResult
{
    /**
     * @var bool Success
     */
    protected $success = true;

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
     * @return ValidationMessage[] Errors
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Get first error.
     *
     * @return ValidationMessage|null Error message
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
     * @return $this
     */
    public function setMessage(string $message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Set the success status.
     *
     * @param bool $success The success status
     *
     * @return $this self
     */
    public function setSuccess(bool $success)
    {
        $this->success = $success;

        return $this;
    }

    /**
     * Returns the success of the validation.
     *
     * @return bool true if validation was successful; otherwise, false
     */
    public function isSuccess(): bool
    {
        return $this->success;
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
     * @return $this
     */
    public function clear()
    {
        $this->message = null;
        $this->errors = [];
        $this->success = true;

        return $this;
    }

    /**
     * Add error message.
     *
     * @param string $field the field name containing the error
     * @param string $message a String providing a short description of the error.
     * The message SHOULD be limited to a concise single sentence
     * @param string|null $code A numeric or alphanumeric value that indicates the error type that occurred. (optional)
     *
     * @return $this
     */
    public function addError(string $field, string $message, string $code = null)
    {
        $this->setSuccess(false);
        $this->errors[] = new ValidationMessage($field, $message, $code);

        return $this;
    }

    /**
     * Convert to array.
     *
     * @return array Data
     */
    public function toArray(): array
    {
        $result = [
            'success' => $this->isSuccess(),
        ];

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
}
