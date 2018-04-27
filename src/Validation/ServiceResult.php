<?php

namespace Odan\Validation;

/**
 * ServiceResult.
 */
class ServiceResult extends ValidationResult
{
    /**
     * @var mixed|null
     */
    protected $result;

    /**
     * @var mixed|null Code
     */
    protected $code = null;

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
     * Get the result.
     *
     * @return mixed The result data
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set the result.
     *
     * @param mixed $result The result data
     *
     * @return $this self
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Convert to array.
     *
     * @return array Data
     */
    public function toArray(): array
    {
        $data = parent::toArray();

        $code = $this->getCode();
        if ($code !== null) {
            $data['code'] = $code;
        }

        $result = $this->getResult();
        if ($result !== null) {
            $data['result'] = $this->getResult();
        }

        return $data;
    }
}
