<?php

namespace Odan\Validation;

/**
 * StatusMessage.
 *
 * Represents a numeric status code and a status message.
 */
class StatusMessage
{
    /**
     * @var int
     */
    protected $status = 0;

    /**
     * @var string
     */
    protected $message;

    /**
     * Constructor.
     *
     * @param int $status Status code
     * @param string $message The message
     */
    public function __construct(int $status, string $message)
    {
        $this->status = $status;
        $this->message = $message;
    }

    /**
     * Clone object.
     *
     * @param int $status Status code
     * @param string $message The message
     *
     * @return self
     */
    public function with(int $status, string $message): self
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
     * @return int The status code
     */
    public function status(): int
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
