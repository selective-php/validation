<?php

namespace Odan\Validation;

/**
 * StatusMessage.
 *
 * Represents a status code ('5001', 'success', 'danger', etc...) and a status message.
 */
class StatusCodeMessage
{
    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $message;

    /**
     * Constructor.
     *
     * @param string $status Alert status
     * @param string $message The message
     */
    public function __construct(string $status, string $message)
    {
        $this->status = $status;
        $this->message = $message;
    }

    /**
     * Clone object.
     *
     * @param string $status Status code
     * @param string $message The message
     *
     * @return self
     */
    public function with(string $status, string $message): self
    {
        return new self($status, $message);
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
     * @return string The status
     */
    public function status(): string
    {
        return $this->status;
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
