<?php

namespace Selective\Validation\Transformer;

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
     *
     * @return array<mixed> The transformed result
     */
    public function transform(ValidationResult $validationResult): array;
}
