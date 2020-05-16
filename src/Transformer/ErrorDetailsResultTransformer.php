<?php

namespace Selective\Validation\Transformer;

use Selective\Validation\ValidationError;
use Selective\Validation\ValidationResult;

/**
 * Transform validation result to array with error details.
 */
final class ErrorDetailsResultTransformer implements ResultTransformerInterface
{
    /**
     * @var string
     */
    private $detailsName;

    /**
     * The constructor.
     *
     * @param string $detailsName The name of the details index
     */
    public function __construct(string $detailsName = 'details')
    {
        $this->detailsName = $detailsName;
    }

    /**
     * Transform the given ValidationResult into an array.
     *
     * @param ValidationResult $validationResult The validation result
     *
     * @return array<mixed> The transformed result
     */
    public function transform(ValidationResult $validationResult): array
    {
        $error = [];

        $code = $validationResult->getCode();
        if ($code !== null) {
            $error['code'] = $code;
        }

        $message = $validationResult->getMessage();
        if ($message !== null) {
            $error['message'] = $message;
        }

        $errors = $validationResult->getErrors();
        if ($errors) {
            $error[$this->detailsName] = $this->getErrorDetails($errors);
        }

        return ['error' => $error];
    }

    /**
     * Get error details.
     *
     * @param ValidationError[] $errors The errors
     *
     * @return array<mixed> The details as array
     */
    private function getErrorDetails(array $errors): array
    {
        $details = [];

        foreach ($errors as $error) {
            $item = [
                'message' => $error->getMessage(),
            ];

            $fieldName = $error->getField();
            if ($fieldName !== null) {
                $item['field'] = $fieldName;
            }

            $errorCode = $error->getCode();
            if ($errorCode !== null) {
                $item['code'] = $errorCode;
            }

            $details[] = $item;
        }

        return $details;
    }
}
