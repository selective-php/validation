<?php

namespace Selective\Validation;

/**
 * Validation error message.
 *
 * Represents a single error message.
 */
final class ValidationError
{
    /**
     * @var string
     */
    private $message;

    /**
     * @var string|null
     */
    private $field;

    /**
     * @var string|null
     */
    private $code;

    /**
     * Constructor.
     *
     * @param string $message The Message
     */
    public function __construct(string $message)
    {
        $this->message = $message;
    }

    /**
     * Returns the message.
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Set the field name.
     *
     * @param string $field The field name
     *
     * @return self The same instance
     */
    public function setField(string $field): self
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Returns the field name.
     *
     * @return string|null The field name
     */
    public function getField(): ?string
    {
        return $this->field;
    }

    /**
     * Set the field name.
     *
     * @param string|null $code The error code
     *
     * @return self The same instance
     */
    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Returns the validation status code.
     *
     * @return string|null The validation status code
     */
    public function getCode(): ?string
    {
        return $this->code;
    }
}
