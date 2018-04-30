<?php

namespace Odan\Validation;

use JsonSerializable;

/**
 * Encapsulates the state of model binding to a property of an action-method argument, or to the argument itself.
 */
class ServiceResult implements JsonSerializable
{
    /**
     * @var bool Success
     */
    protected $success = true;

    /**
     * @var string|null
     */
    protected $message = null;

    /**
     * @var mixed|null Code
     */
    protected $code = null;

    /**
     * @var mixed|null
     */
    protected $data;

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
     * Get the code.
     *
     * @return mixed|null
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the code.
     *
     * @param mixed $code The status code
     *
     * @return $this self
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Returns the the document’s "primary data".
     *
     * @return mixed The result data
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the result data.
     *
     * @param mixed $result The result data
     *
     * @return $this self
     */
    public function setData($result)
    {
        $this->data = $result;

        return $this;
    }

    /**
     * Convert to array.
     *
     * @return array Data
     */
    public function toArray(): array
    {
        $data = [
            'success' => $this->isSuccess(),
        ];

        $message = $this->getMessage();
        if ($message !== null) {
            $data['message'] = $message;
        }

        $code = $this->getCode();
        if ($code !== null) {
            $data['code'] = $code;
        }

        $result = $this->getData();
        if ($result !== null) {
            $data['data'] = $this->getData();
        }

        return $data;
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
