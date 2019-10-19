<?php

namespace Selective\Validation\Exception;

use DomainException;
use Selective\Validation\ValidationResult;
use Throwable;

/**
 * Class ValidationException.
 */
class ValidationException extends DomainException
{
    /**
     * @var ValidationResult
     */
    protected $validationResult;

    /**
     * Construct the exception.
     *
     * @param ValidationResult $validationResult The validation result object
     * @param string $message [optional] The Exception message to throw
     * @param int $code [optional] The Exception code
     * @param Throwable|null $previous [optional] The previous throwable used for the exception chaining
     */
    public function __construct(
        ValidationResult $validationResult,
        string $message = '',
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->validationResult = $validationResult;
    }

    /**
     * @return ValidationResult
     */
    public function getValidation(): ValidationResult
    {
        return $this->validationResult;
    }
}
