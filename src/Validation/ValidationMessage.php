<?php

namespace Odan\Validation;

/**
 * Message.
 *
 * Represents a status and a message.
 */
class ValidationMessage
{
    /**
     * @var string
     */
    protected $field;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string|null
     */
    protected $code = null;

    /**
     * Constructor.
     *
     * @param string $field The field name
     * @param string $message The Message
     * @param string|null $code The error code (optional)
     */
    public function __construct(string $field, string $message, string $code = null)
    {
        $this->field = $field;
        $this->message = $message;
        $this->code = $code;
    }

    /**
     * Returns the message.
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Returns the field name.
     *
     * @return string The field name
     */
    public function getField(): string
    {
        return $this->field;
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

    /**
     * Convert to array.
     *
     * @return array Data
     */
    public function toArray(): array
    {
        $result = [
            'field' => $this->getField(),
            'message' => $this->getMessage(),
        ];

        $code = $this->getCode();
        if ($code !== null) {
            $result['code'] = $code;
        }

        return $result;
    }
}
