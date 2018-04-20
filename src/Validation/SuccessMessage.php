<?php

namespace Odan\Validation;

/**
 * Success Message.
 *
 * Represents a boolean success status and a success message.
 */
class SuccessMessage
{
    /**
     * @var bool
     */
    protected $success = false;

    /**
     * @var string
     */
    protected $message = null;

    /**
     * Constructor.
     *
     * @param bool $success Success
     * @param string $message Message
     */
    public function __construct(bool $success, string $message)
    {
        $this->success = $success;
        $this->message = $message;
    }

    /**
     * Set values.
     *
     * @param bool $success
     * @param string $message
     *
     * @return void
     */
    public function set(bool $success, string $message)
    {
        $this->success = $success;
        $this->message = $message;
    }

    /**
     * Returns the message.
     *
     * @return string
     */
    public function message(): string
    {
        return $this->message;
    }

    /**
     * Returns the success status.
     *
     * @return bool The success status
     */
    public function success(): bool
    {
        return $this->success;
    }

    /**
     * Returns the failed status.
     *
     * @return bool The failed status
     */
    public function failed(): bool
    {
        return !$this->success;
    }

    /**
     * Convert to array.
     *
     * @return array Data
     */
    public function toArray(): array
    {
        return [
            'success' => $this->success(),
            'message' => $this->message(),
        ];
    }
}
