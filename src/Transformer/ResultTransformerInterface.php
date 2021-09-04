<?php

namespace Selective\Validation\Transformer;

use Selective\Validation\Exception\ValidationException;
use Selective\Validation\ValidationResult;

/**
 * Transformer interface.
 */
interface ResultTransformerInterface
{
    /**
     * Transform the given ValidationResult into an array.
     *
     * @param ValidationResult $validationResult The validation result
     * @param ValidationException|null $exception The validation exception
     *
     * @return array The transformed result
     */
    public function transform(ValidationResult $validationResult, ValidationException $exception = null): array;
}
