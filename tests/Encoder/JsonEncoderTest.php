<?php

namespace Selective\Validation\Test\Encoder;

use PHPUnit\Framework\TestCase;
use Selective\Validation\Encoder\JsonEncoder;
use UnexpectedValueException;

/**
 * Tests.
 *
 * @coversDefaultClass \Selective\Validation\Encoder\JsonEncoder
 */
class JsonEncoderTest extends TestCase
{
    /**
     * Test.
     *
     * @return void
     */
    public function testEncode()
    {
        $encoder = new JsonEncoder();
        $actual = $encoder->encode(['key' => 'value']);

        static::assertSame('{"key":"value"}', $actual);
    }

    /**
     * Test.
     *
     * @return void
     */
    public function testInvalidEncoding(): void
    {
        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('JSON encoding failed. Code: 5. Error: Malformed UTF-8 characters, possibly incorrectly encoded.');

        $encoder = new JsonEncoder();
        $encoder->encode(['key' => "\x00\x81"]);
    }
}
