<?php

namespace Selective\Validation\Encoder;

use UnexpectedValueException;

/**
 * Encoder interface.
 */
final class JsonEncoder implements EncoderInterface
{
    /**
     * Encode the given data to string.
     *
     * @param mixed $data The data
     *
     * @throws UnexpectedValueException
     *
     * @return string The encoded string
     */
    public function encode($data): string
    {
        $result = json_encode($data);

        if ($result === false) {
            throw new UnexpectedValueException(
                sprintf('JSON encoding failed. Code: %s. Error: %s.', json_last_error(), json_last_error_msg())
            );
        }

        return $result;
    }
}
