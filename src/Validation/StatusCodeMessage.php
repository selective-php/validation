<?php

namespace Odan\Validation;

/**
 * Status Code Message.
 *
 * Represents a status code ('5001', 'success', 'danger', etc...) and a status message.
 */
class StatusCodeMessage
{
    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $message;

    /**
     * Constructor.
     *
     * @param string $code Alert status
     * @param string $message The message
     */
    public function __construct(string $code, string $message)
    {
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * Set values.
     *
     * @param string $code Status code
     * @param string $message The message
     *
     * @return void
     */
    public function set(string $code, string $message)
    {
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * Returns the message.
     *
     * @return string The message
     */
    public function message(): string
    {
        return $this->message;
    }

    /**
     * Returns the status code.
     *
     * @return string The status code
     */
    public function status(): string
    {
        return $this->code;
    }

    /**
     * Convert to array.
     *
     * @return array Data
     */
    public function toArray(): array
    {
        return [
            'status' => $this->status(),
            'message' => $this->message(),
        ];
    }
}
