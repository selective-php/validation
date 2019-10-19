<?php

namespace Selective\Validation;

/**
 * Message.
 *
 * Represents a status and a message.
 */
class ValidationError
{
    /**
     * @var string|null
     */
    protected $field;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var string|null
     */
    protected $code;

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
     *
     * @return string
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
     * @return $this self
     */
    public function setField(string $field)
    {
        $this->field = $field;

        return $this;
    }

    /**
     * Returns the field name.
     *
     * @return string|null The field name
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Set the field name.
     *
     * @param mixed $code The error code
     *
     * @return $this self
     */
    public function setCode($code)
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

    /**
     * Convert to array.
     *
     * @return array Data
     */
    public function toArray(): array
    {
        $result = [
            'message' => $this->getMessage(),
        ];

        $fieldName = $this->getField();
        if ($fieldName !== null) {
            $result['field'] = $fieldName;
        }

        $errorCode = $this->getCode();
        if ($errorCode !== null) {
            $result['code'] = $errorCode;
        }

        return $result;
    }
}
